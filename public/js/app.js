// Main Carpool India Application
class CarpoolApp {
    constructor() {
        this.map = null;
        this.markers = [];
        this.autocompleteTimeout = null;
        this.init();
    }

    init() {
        console.log('🚗 Carpool India App Initialized');
        
        // Initialize all components
        this.initMap();
        this.initSearch();
        this.initCounters();
        this.initAutocomplete();
        this.initForms();
        this.initNotifications();
        this.initScrollEffects();
        
        // Set minimum date for date inputs
        this.setMinDate();
    }

    // Initialize OpenStreetMap
    initMap() {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        try {
            // Initialize map with Delhi coordinates
            this.map = L.map('map').setView([28.6139, 77.2090], 10);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18
            }).addTo(this.map);

            // Load ride markers
            this.loadRideMarkers();
            
            console.log('🗺️ Map initialized successfully');
        } catch (error) {
            console.error('Map initialization error:', error);
            this.showNotification('Failed to load map', 'error');
        }
    }

    // Load ride markers on map
    async loadRideMarkers() {
        try {
            const response = await fetch('/api/map-data');
            const data = await response.json();
            
            if (data.success && data.rides) {
                this.clearMarkers();
                
                data.rides.forEach(ride => {
                    if (ride.source_lat && ride.source_lng) {
                        this.addRideMarker(ride);
                    }
                });
                
                console.log(`📍 Loaded ${data.rides.length} ride markers`);
            }
        } catch (error) {
            console.error('Failed to load ride markers:', error);
        }
    }

    // Add a ride marker to map
    addRideMarker(ride) {
        const marker = L.marker([ride.source_lat, ride.source_lng]);
        
        const popupContent = `
            <div class="ride-popup">
                <h4 class="text-primary mb-2">${ride.driver_name}</h4>
                <div class="route-info mb-2">
                    <div class="route-point">
                        <i class="fas fa-circle text-success mr-2"></i>
                        <span>${ride.source}</span>
                    </div>
                    <div class="route-point">
                        <i class="fas fa-circle text-danger mr-2"></i>
                        <span>${ride.destination}</span>
                    </div>
                </div>
                <div class="ride-details d-flex justify-between items-center">
                    <div>
                        <span class="text-success font-bold text-lg">₹${ride.price_per_seat}</span>
                        <div class="text-sm text-gray-500">${ride.seats_available} seats left</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">${this.formatDate(ride.ride_date)}</div>
                        <div class="text-sm text-gray-500">${this.formatTime(ride.ride_time)}</div>
                    </div>
                </div>
                <button onclick="app.bookRideFromMap(${ride.id})" 
                        class="btn btn-primary btn-sm w-full mt-3">
                    Book Now
                </button>
            </div>
        `;
        
        marker.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });
        
        marker.addTo(this.map);
        this.markers.push(marker);
    }

    // Clear all markers
    clearMarkers() {
        this.markers.forEach(marker => {
            this.map.removeLayer(marker);
        });
        this.markers = [];
    }

    // Initialize search functionality
    initSearch() {
        const searchForm = document.getElementById('searchForm');
        const quickSearchForm = document.getElementById('quickSearchForm');
        
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => this.handleSearch(e));
        }
        
        if (quickSearchForm) {
            quickSearchForm.addEventListener('submit', (e) => this.handleQuickSearch(e));
        }
    }

    // Handle search form submission
    async handleSearch(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const source = formData.get('source')?.trim();
        const destination = formData.get('destination')?.trim();
        const date = formData.get('date');
        
        if (!source || !destination || !date) {
            this.showNotification('Please fill all search fields', 'warning');
            return;
        }
        
        this.showLoading(e.target.querySelector('button[type="submit"]'));
        
        try {
            const response = await fetch('/api/search-rides', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                if (result.rides && result.rides.length > 0) {
                    this.displaySearchResults(result.rides);
                    this.showNotification(`Found ${result.rides.length} rides!`, 'success');
                } else {
                    this.showNotification('No rides found for your search', 'info');
                }
            } else {
                this.showNotification(result.message || 'Search failed', 'error');
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showNotification('Search failed. Please try again.', 'error');
        } finally {
            this.hideLoading(e.target.querySelector('button[type="submit"]'));
        }
    }

    // Handle quick search (redirect to dashboard)
    handleQuickSearch(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const source = formData.get('source')?.trim();
        const destination = formData.get('destination')?.trim();
        const date = formData.get('date');
        
        if (!source || !destination || !date) {
            this.showNotification('Please fill all search fields', 'warning');
            return;
        }
        
        // Store search parameters and redirect to dashboard
        sessionStorage.setItem('searchParams', JSON.stringify({
            source, destination, date
        }));
        
        window.location.href = '/dashboard?search=true';
    }

    // Display search results
    displaySearchResults(rides) {
        const resultsContainer = document.getElementById('searchResults');
        if (!resultsContainer) return;
        
        const resultsHTML = rides.map(ride => this.createRideCard(ride)).join('');
        
        resultsContainer.innerHTML = `
            <div class="search-results">
                <h3 class="mb-4">Search Results (${rides.length} rides found)</h3>
                <div class="rides-grid">
                    ${resultsHTML}
                </div>
            </div>
        `;
        
        // Scroll to results
        resultsContainer.scrollIntoView({ behavior: 'smooth' });
    }

    // Create ride card HTML
    createRideCard(ride) {
        return `
            <div class="ride-card">
                <div class="ride-header">
                    <div class="ride-avatar">
                        ${ride.driver_name.substring(0, 2).toUpperCase()}
                    </div>
                    <div class="ride-info">
                        <h4>${ride.driver_name}</h4>
                        <p>${ride.vehicle_model || 'Vehicle'} • ${ride.number_plate || ''}</p>
                    </div>
                </div>
                
                <div class="route-info">
                    <div class="route-point route-from">
                        <i class="fas fa-circle"></i>
                        <span>${ride.source}</span>
                    </div>
                    <div class="route-point route-to">
                        <i class="fas fa-circle"></i>
                        <span>${ride.destination}</span>
                    </div>
                </div>
                
                <div class="ride-timing mb-3">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    ${this.formatDate(ride.ride_date)} at ${this.formatTime(ride.ride_time)}
                </div>
                
                <div class="ride-footer">
                    <div class="ride-pricing">
                        <div class="ride-price">₹${ride.price_per_seat}</div>
                        <div class="ride-seats">${ride.seats_available} seats left</div>
                    </div>
                    <button onclick="app.bookRide(${ride.id}, '${ride.driver_name}')" 
                            class="btn btn-primary btn-sm">
                        Book Now
                    </button>
                </div>
            </div>
        `;
    }

    // Initialize animated counters
    initCounters() {
        const counters = document.querySelectorAll('.counter');
        if (counters.length === 0) return;

        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));
    }

    // Animate counter
    animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target')) || 0;
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current >= target) {
                current = target;
                element.textContent = this.formatNumber(target);
                return;
            }
            element.textContent = this.formatNumber(Math.floor(current));
            requestAnimationFrame(updateCounter);
        };

        updateCounter();
    }

    // Initialize autocomplete
    initAutocomplete() {
        const inputs = document.querySelectorAll('input[data-autocomplete="location"]');
        
        inputs.forEach(input => {
            const resultsId = input.getAttribute('data-results') || input.id + 'Results';
            this.setupAutocomplete(input, resultsId);
        });
    }

    // Setup autocomplete for input
    setupAutocomplete(input, resultsId) {
        let resultsDiv = document.getElementById(resultsId);
        
        // Create results div if it doesn't exist
        if (!resultsDiv) {
            resultsDiv = document.createElement('div');
            resultsDiv.id = resultsId;
            resultsDiv.className = 'autocomplete-dropdown hidden';
            input.parentNode.appendChild(resultsDiv);
            input.parentNode.style.position = 'relative';
        }
        
        input.addEventListener('input', (e) => {
            clearTimeout(this.autocompleteTimeout);
            const query = e.target.value.trim();
            
            if (query.length < 3) {
                this.hideAutocomplete(resultsId);
                return;
            }
            
            this.autocompleteTimeout = setTimeout(() => {
                this.fetchLocationSuggestions(query, resultsId);
            }, 300);
        });

        // Hide results when clicking outside
        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !resultsDiv.contains(e.target)) {
                this.hideAutocomplete(resultsId);
            }
        });
    }

    // Fetch location suggestions
    async fetchLocationSuggestions(query, resultsId) {
        try {
            const response = await fetch(`/api/geocode?q=${encodeURIComponent(query)}`);
            const suggestions = await response.json();
            
            this.displayAutocomplete(suggestions, resultsId);
        } catch (error) {
            console.error('Geocoding error:', error);
            this.hideAutocomplete(resultsId);
        }
    }

    // Display autocomplete suggestions
    displayAutocomplete(suggestions, resultsId) {
        const resultsDiv = document.getElementById(resultsId);
        
        if (!suggestions || suggestions.length === 0) {
            this.hideAutocomplete(resultsId);
            return;
        }
        
        const html = suggestions.map(suggestion => `
            <div class="autocomplete-item" onclick="app.selectSuggestion('${suggestion.display_name}', '${resultsId}')">
                <div class="font-medium">${suggestion.display_name}</div>
            </div>
        `).join('');
        
        resultsDiv.innerHTML = html;
        resultsDiv.classList.remove('hidden');
    }

    // Select autocomplete suggestion
    selectSuggestion(value, resultsId) {
        const inputId = resultsId.replace('Results', '').replace('Dropdown', '');
        const input = document.getElementById(inputId) || 
                     document.querySelector(`input[data-results="${resultsId}"]`);
        
        if (input) {
            input.value = value;
            this.hideAutocomplete(resultsId);
            input.focus();
        }
    }

    // Hide autocomplete
    hideAutocomplete(resultsId) {
        const resultsDiv = document.getElementById(resultsId);
        if (resultsDiv) {
            resultsDiv.classList.add('hidden');
        }
    }

    // Initialize forms
    initForms() {
        // Add form validation and submission handling
        const forms = document.querySelectorAll('form[data-ajax="true"]');
        
        forms.forEach(form => {
            form.addEventListener('submit', (e) => this.handleAjaxForm(e));
        });
    }

    // Handle AJAX form submission
    async handleAjaxForm(e) {
        e.preventDefault();
        
        const form = e.target;
        const button = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        this.showLoading(button);
        
        try {
            const response = await fetch(form.action || window.location.pathname, {
                method: form.method || 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification(result.message || 'Success!', 'success');
                
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1000);
                } else if (result.reset) {
                    form.reset();
                } else if (result.reload) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                this.showNotification(result.message || 'An error occurred', 'error');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            this.showNotification('Failed to submit form. Please try again.', 'error');
        } finally {
            this.hideLoading(button);
        }
    }

    // Initialize notifications
    initNotifications() {
        // Remove any existing notifications after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => {
                notification.remove();
            });
        }, 5000);
    }

    // Show notification
    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        notification.innerHTML = `
            <div class="d-flex items-center justify-between">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" 
                        class="ml-3 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }

    // Initialize scroll effects
    initScrollEffects() {
        const navbar = document.querySelector('.navbar');
        
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }
        
        // Animate elements on scroll
        const animateOnScroll = document.querySelectorAll('[data-animate]');
        
        if (animateOnScroll.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const animationType = entry.target.getAttribute('data-animate');
                        entry.target.classList.add(`animate-${animationType}`);
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            animateOnScroll.forEach(el => observer.observe(el));
        }
    }

    // Set minimum date for date inputs
    setMinDate() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        
        dateInputs.forEach(input => {
            input.min = today;
            if (!input.value) {
                input.value = today;
            }
        });
    }

    // Book ride from map popup
    bookRideFromMap(rideId) {
        if (!this.isLoggedIn()) {
            this.showNotification('Please login to book rides', 'warning');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
            return;
        }
        
        this.bookRide(rideId, 'Driver');
    }

    // Book ride
    async bookRide(rideId, driverName) {
        if (!this.isLoggedIn()) {
            this.showNotification('Please login to book rides', 'warning');
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
            return;
        }
        
        const confirmed = confirm(`Book ride with ${driverName}?`);
        if (!confirmed) return;
        
        try {
            const formData = new FormData();
            formData.append('ride_id', rideId);
            formData.append('seats_requested', 1);
            formData.append('csrf_token', this.getCsrfToken());
            
            const response = await fetch('/dashboard/book-ride', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification('Ride booked successfully!', 'success');
                // Refresh page or update UI
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                this.showNotification(result.message || 'Booking failed', 'error');
            }
        } catch (error) {
            console.error('Booking error:', error);
            this.showNotification('Booking failed. Please try again.', 'error');
        }
    }

    // Utility functions
    isLoggedIn() {
        return document.body.hasAttribute('data-logged-in');
    }

    getCsrfToken() {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        return tokenMeta ? tokenMeta.content : '';
    }

    formatNumber(num) {
        return new Intl.NumberFormat('en-IN').format(num);
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    formatTime(timeString) {
        const [hours, minutes] = timeString.split(':');
        const time = new Date();
        time.setHours(hours, minutes);
        return time.toLocaleTimeString('en-IN', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    showLoading(button) {
        if (button) {
            button.disabled = true;
            const originalText = button.innerHTML;
            button.setAttribute('data-original-text', originalText);
            button.innerHTML = '<span class="spinner mr-2"></span>Loading...';
        }
    }

    hideLoading(button) {
        if (button) {
            button.disabled = false;
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.innerHTML = originalText;
                button.removeAttribute('data-original-text');
            }
        }
    }



}




// Initialize app when DOM is loaded
let app;
document.addEventListener('DOMContentLoaded', () => {
    app = new CarpoolApp();
    console.log('🎉 Carpool India App Ready!');
});

// Global functions for backward compatibility
window.bookRide = (rideId, driverName) => app.bookRide(rideId, driverName);
window.selectSuggestion = (value, resultsId) => app.selectSuggestion(value, resultsId);

// Driver records payment
window.savePayment = async function (bookingId) {
  const sel = document.getElementById('payMode'+bookingId);
  const mode = sel.value;
  if(!mode){ app.showNotification('Select payment mode','warning'); return; }

  const fd = new FormData();
  fd.append('booking_id',bookingId);
  fd.append('mode',mode);
  fd.append('csrf_token',app.getCsrfToken());

  const r = await fetch('/dashboard/record-payment',{method:'POST',body:fd});
  const res = await r.json();
  if(res.success){
      app.showNotification('Payment recorded','success');
      // refresh or update DOM:
      sel.parentElement.innerHTML =
         `<span class="badge ${mode==='cash'?'bg-green-600':'bg-blue-600'}">
               ${mode.charAt(0).toUpperCase()+mode.slice(1)}
          </span>`;
  }else{
      app.showNotification(res.message,'error');
  }
};

// Driver completes ride
window.completeRide = async function (rideId) {
  const fd = new FormData();
  fd.append('ride_id',rideId);
  fd.append('csrf_token',app.getCsrfToken());

  const r = await fetch('/dashboard/complete-ride',{method:'POST',body:fd});
  const res = await r.json();
  if(res.success){
      app.showNotification('Ride marked completed','success');
      setTimeout(()=>location.reload(),1000);
  }else{
      app.showNotification(res.message,'warning');
  }
};

