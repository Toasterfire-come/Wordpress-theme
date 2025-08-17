<?php
/**
 * Template for About Us page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6rem 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; text-align: center;">
            <h1 style="font-size: 4rem; font-weight: bold; margin-bottom: 1.5rem; line-height: 1.1;">
                <?php _e('About Retail Trade Scanner', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.5rem; color: #cbd5e1; margin-bottom: 2rem; max-width: 800px; margin-left: auto; margin-right: auto;">
                <?php _e('Empowering retail traders with institutional-grade market data and analysis tools since 2020.', 'retail-trade-scanner'); ?>
            </p>
        </div>
    </section>

    <!-- Mission Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div>
                    <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 2rem;">
                        <?php _e('Our Mission', 'retail-trade-scanner'); ?>
                    </h2>
                    <p style="font-size: 1.125rem; color: #64748b; line-height: 1.7; margin-bottom: 2rem;">
                        <?php _e('We believe that every retail trader deserves access to the same high-quality market data and analysis tools that professional trading firms use. Our mission is to democratize financial markets by providing powerful, easy-to-use tools that level the playing field.', 'retail-trade-scanner'); ?>
                    </p>
                    <p style="font-size: 1.125rem; color: #64748b; line-height: 1.7;">
                        <?php _e('Since our founding, we\'ve helped over 100,000 traders make more informed investment decisions through real-time data, advanced analytics, and comprehensive market insights.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                <div style="text-align: center;">
                    <div style="background: #f0fdf4; border-radius: 16px; padding: 3rem; display: inline-block;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🎯</div>
                        <h3 style="font-size: 1.5rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem;">
                            <?php _e('100,000+', 'retail-trade-scanner'); ?>
                        </h3>
                        <p style="color: #64748b;">
                            <?php _e('Traders Empowered', 'retail-trade-scanner'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section style="padding: 6rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Our Values', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b; max-width: 600px; margin: 0 auto;">
                    <?php _e('The principles that guide everything we do and every decision we make.', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                
                <!-- Transparency -->
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="width: 64px; height: 64px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">🔍</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Transparency', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Clear pricing, honest data sources, and transparent methodologies. No hidden fees or misleading information.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <!-- Accuracy -->
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="width: 64px; height: 64px; background: #dcfce7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">🎯</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Accuracy', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Institutional-grade data accuracy with 99.9% uptime. Your trading decisions deserve reliable information.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
                <!-- Innovation -->
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="width: 64px; height: 64px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <span style="font-size: 2rem;">⚡</span>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Innovation', 'retail-trade-scanner'); ?>
                    </h3>
                    <p style="color: #64748b; line-height: 1.6;">
                        <?php _e('Continuously improving our platform with cutting-edge technology and user-driven features.', 'retail-trade-scanner'); ?>
                    </p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Meet Our Team', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #64748b; max-width: 600px; margin: 0 auto;">
                    <?php _e('Experienced professionals from finance, technology, and data science working together to serve you.', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <div id="team-members" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                <!-- Team members populated by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section style="padding: 6rem 0; background: #0f172a; color: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem;">
                    <?php _e('By the Numbers', 'retail-trade-scanner'); ?>
                </h2>
                <p style="font-size: 1.125rem; color: #cbd5e1;">
                    <?php _e('Our platform\'s impact on the retail trading community', 'retail-trade-scanner'); ?>
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; text-align: center;">
                
                <div>
                    <div style="font-size: 3rem; font-weight: bold; color: #34d399; margin-bottom: 0.5rem;">100K+</div>
                    <div style="color: #cbd5e1; font-size: 1.125rem;">Active Users</div>
                </div>
                
                <div>
                    <div style="font-size: 3rem; font-weight: bold; color: #34d399; margin-bottom: 0.5rem;">50M+</div>
                    <div style="color: #cbd5e1; font-size: 1.125rem;">Data Points Daily</div>
                </div>
                
                <div>
                    <div style="font-size: 3rem; font-weight: bold; color: #34d399; margin-bottom: 0.5rem;">99.9%</div>
                    <div style="color: #cbd5e1; font-size: 1.125rem;">Uptime</div>
                </div>
                
                <div>
                    <div style="font-size: 3rem; font-weight: bold; color: #34d399; margin-bottom: 0.5rem;">24/7</div>
                    <div style="color: #cbd5e1; font-size: 1.125rem;">Support</div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section style="padding: 6rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 1rem; text-align: center;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e('Ready to Get Started?', 'retail-trade-scanner'); ?>
            </h2>
            <p style="font-size: 1.125rem; color: #64748b; margin-bottom: 2rem;">
                <?php _e('Join thousands of traders who trust Retail Trade Scanner for their market analysis needs.', 'retail-trade-scanner'); ?>
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('signup'))); ?>" style="background: #059669; color: white; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.125rem; transition: all 0.2s;">
                    <?php _e('Start Free Trial', 'retail-trade-scanner'); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" style="border: 2px solid #e2e8f0; color: #374151; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.125rem; transition: all 0.2s;">
                    <?php _e('Contact Us', 'retail-trade-scanner'); ?>
                </a>
            </div>
        </div>
    </section>

</main>

<script>
// About page JavaScript
const teamMembers = [
    {
        name: 'Sarah Chen',
        role: 'CEO & Co-founder',
        bio: 'Former Goldman Sachs VP with 15 years in quantitative trading. MIT graduate with expertise in algorithmic trading systems.',
        avatar: '👩‍💼'
    },
    {
        name: 'Michael Rodriguez',
        role: 'CTO & Co-founder',
        bio: 'Ex-Google engineer specializing in high-frequency data processing. Built trading platforms handling millions of transactions daily.',
        avatar: '👨‍💻'
    },
    {
        name: 'David Kim',
        role: 'Head of Data Science',
        bio: 'PhD in Statistics from Stanford. Former quantitative researcher at Two Sigma with expertise in market prediction models.',
        avatar: '👨‍🔬'
    },
    {
        name: 'Emily Johnson',
        role: 'Head of Product',
        bio: 'Former product manager at Bloomberg Terminal. Passionate about creating intuitive interfaces for complex financial data.',
        avatar: '👩‍🎨'
    },
    {
        name: 'Alex Thompson',
        role: 'Head of Customer Success',
        bio: '10+ years in financial services. Previously led customer success teams at TD Ameritrade and Charles Schwab.',
        avatar: '👨‍💼'
    },
    {
        name: 'Lisa Wang',
        role: 'Lead Security Engineer',
        bio: 'Cybersecurity expert with focus on financial systems. Former security architect at JPMorgan Chase.',
        avatar: '👩‍🔧'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    displayTeamMembers();
});

function displayTeamMembers() {
    const container = document.getElementById('team-members');
    
    container.innerHTML = teamMembers.map(member => `
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-4px)'" onmouseleave="this.style.transform='translateY(0)'">
            <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2rem;">
                ${member.avatar}
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">
                ${member.name}
            </h3>
            <div style="color: #059669; font-weight: 500; margin-bottom: 1rem; font-size: 0.875rem;">
                ${member.role}
            </div>
            <p style="color: #64748b; line-height: 1.6; font-size: 0.875rem;">
                ${member.bio}
            </p>
        </div>
    `).join('');
}
</script>

<?php get_footer(); ?>