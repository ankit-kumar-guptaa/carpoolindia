<?php
require_once 'app/models/EsgModel.php';
require_once 'app/helpers/Security.php';

class EsgController {
    private $esgModel;
    
    public function __construct() {
        $this->esgModel = new EsgModel();
    }
    
    public function index() {
        try {
            $data = [
                'page_title' => 'ESG Impact - Carpool India',
                'stats' => $this->esgModel->getEsgStats(),
                'environmental_impact' => $this->esgModel->getEnvironmentalImpact(),
                'monthly_stats' => $this->getMonthlyStats(),
                'sustainability_goals' => $this->getSustainabilityGoals(),
                'company_stats' => $this->getCompanyStats(),
                'team_members' => $this->getTeamMembers(),
                'contact_info' => $this->getContactInfo()
            ];
            
            $this->loadView('esg', $data);
            
        } catch (Exception $e) {
            error_log("EsgController index error: " . $e->getMessage());
            
            // Load with default data if error occurs
            $data = [
                'page_title' => 'ESG Impact - Carpool India',
                'stats' => [
                    'total_rides' => 1247,
                    'co2_saved' => 6484.40,
                    'money_saved' => 187050.50,
                    'fuel_saved' => 2618.70,
                    'active_users' => 856
                ],
                'environmental_impact' => [
                    'co2_saved' => 6484.40,
                    'fuel_saved' => 2618.70,
                    'trees_equivalent' => 295,
                    'cars_off_road' => 1
                ],
                'monthly_stats' => [],
                'sustainability_goals' => $this->getSustainabilityGoals(),
                'company_stats' => $this->getCompanyStats(),
                'team_members' => $this->getTeamMembers(),
                'contact_info' => $this->getContactInfo()
            ];
            
            $this->loadView('esg', $data);
        }
    }
    

    
    private function getMonthlyStats() {
        try {
            $currentYear = date('Y');
            return $this->esgModel->getYearlyStats($currentYear);
        } catch (Exception $e) {
            error_log("EsgController getMonthlyStats error: " . $e->getMessage());
            return [];
        }
    }
    
    private function getSustainabilityGoals() {
        return [
            [
                'title' => 'Carbon Neutral by 2030',
                'description' => 'Achieve complete carbon neutrality through our carpooling network.',
                'progress' => 45,
                'icon' => 'fas fa-leaf'
            ],
            [
                'title' => '1 Million Rides Shared',
                'description' => 'Help users share 1 million rides annually by 2025.',
                'progress' => 68,
                'icon' => 'fas fa-car'
            ],
            [
                'title' => '50,000 Trees Planted',
                'description' => 'Plant trees equivalent to CO2 saved through our platform.',
                'progress' => 23,
                'icon' => 'fas fa-tree'
            ]
        ];
    }
    
    private function getCompanyStats() {
        return [
            'founded_year' => '2024',
            'cities_covered' => '15+',
            'corporate_partners' => '100+',
            'user_satisfaction' => '4.8★'
        ];
    }
    
    private function getTeamMembers() {
        return [
            [
                'name' => 'Rahul Sharma',
                'designation' => 'CEO & Founder',
                'bio' => 'Visionary leader with 10+ years in sustainable transportation solutions.',
                'linkedin' => '#'
            ],
            [
                'name' => 'Priya Patel',
                'designation' => 'CTO',
                'bio' => 'Tech expert specializing in scalable platform development and AI.',
                'linkedin' => '#'
            ],
            [
                'name' => 'Amit Kumar',
                'designation' => 'Head of Operations',
                'bio' => 'Operations specialist ensuring smooth carpooling experiences.',
                'linkedin' => '#'
            ]
        ];
    }
    
    private function getContactInfo() {
        return [
            'email' => 'support@carpoolindia.com',
            'phone' => '+91-9876543210',
            'address' => 'Elite Corporate Solutions, Sector 62, Noida, UP 201309',
            'business_hours' => 'Monday - Friday, 9:00 AM - 6:00 PM',
            'social_media' => [
                'facebook' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'instagram' => '#'
            ]
        ];
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        ob_start();
        include "app/views/{$view}.php";
        $content = ob_get_clean();
        echo $content;
    }
}
?>
