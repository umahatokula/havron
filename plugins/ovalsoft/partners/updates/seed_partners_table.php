<?php namespace Ovalsoft\Courses\Updates;

use Seeder;
use Ovalsoft\Partners\Models\Partner;

class SeedPartnersTable extends Seeder
{
    public function run()
    {
        Partner::create([
            'name'  => 'University of Washington Department of Global Health E-Learning',
            'slug'  => 'university-washington-department-global-health-e-Learning',
            'information'  => '<p>Leadership and Management in Health, where over 500 professionals have acquired this certificate through HPDG.</p>
                <ul>
                    <li>Global Health Project Management, where about 360 professionals participated through HPDG</li>
                    <li>Economic Evaluation in Global Health, 240 professionals have received this training through HPDG</li>
                    <li>Fundamentals of Global Health Research, where we facilitated 100 participants to pass through the course</li>
                    <li>Clinical Management of HIV, 180 professionals have passed through HPDG to acquire this certificate</li>
                    <li>Introduction to Epidemiology in Global Health, over 150 professionals have passed through us to acquire this certificate</li>
                </ul>
            <p>There are few upcoming courses from the university that we are priming to coordinate.</p>
            ',
        ]);

        Partner::create([
            'name'  => 'James Lind Institute India',
            'slug'  => 'James-lind-institute-india',
            'information'  => '<p>Since 2018, Havron Professional Development Group has been partnering with James Lind Institute and has recruited students into the various post graduate diploma including courses and master’s in public health programs. We have recruited 15 candidates into Advanced Post Graduate Diploma and 2 candidates into master’s in public health.</p>',
        ]);

        Partner::create([
            'name'  => 'UNICAF University',
            'slug'  => 'unicaf-university',
            'information'  => '<p>Havron Professional Development Group went into partnership with UNICAF University in 2018 and has recruited 10 candidates into master’s programs and 15 candidates into professional development courses.</p>',
        ]);

        Partner::create([
            'name'  => 'Texila American University, India',
            'slug'  => 'texila-america-university-india',
            'information'  => '<p></p>Havron Professional Development and Educational Services through the Director, Pharm Samson Emelike as a Student Ambassador, has been in this role since 2014 and has recruited over 50 candidates into different programs including professional development courses, bachelor, masters and PhD programs offered by the institution, and still counting.</p>
            </p>As a result of increasing demands from our members to expand the list of our courses, we are ever searching for institutions of repute to explore possibilities of partnership to broaden our horizon</p>.
',
        ]);
    }
}