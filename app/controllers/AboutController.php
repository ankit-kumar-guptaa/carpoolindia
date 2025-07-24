<?php
require_once 'app/helpers/Security.php';

class AboutController {
    public function index() {
        $data = [
            'page_title' => 'About Us - Carpool India',
            'team_members' => $this->getTeamMembers(),
            'company_stats' => $this->getCompanyStats()
        ];
        
        $this->loadView('about', $data);
    }
    
    private function getTeamMembers() {
        return [
            [
                'name' => 'Rajesh Kumar',
                'designation' => 'Founder & CEO',
                'image' => 'team-1.jpg',
                'bio' => 'Passionate about sustainable transportation and building communities.',
                'linkedin' => '#'
            ],
            [
                'name' => 'Priya Sharma',
                'designation' => 'CTO',
                'image' => 'team-2.jpg',
                'bio' => 'Tech enthusiast with 10+ years experience in building scalable platforms.',
                'linkedin' => '#'
            ],
            [
                'name' => 'Amit Patel',
                'designation' => 'Head of Operations',
                'image' => 'team-3.jpg',
                'bio' => 'Operations expert focused on user experience and safety.',
                'linkedin' => '#'
            ]
        ];
    }
    
    private function getCompanyStats() {
        return [
            'founded_year' => '2024',
            'cities_covered' => '15+',
            'corporate_partners' => '100+',
            'user_satisfaction' => '4.8/5'
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
