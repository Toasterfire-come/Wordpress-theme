<?php
/**
 * Template for System Status page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e('System Status', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 2rem;">
                <?php _e('Real-time system status and performance metrics', 'retail-trade-scanner'); ?>
            </p>
            
            <!-- Overall Status -->
            <div id="overall-status" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; padding: 1rem 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <div style="width: 12px; height: 12px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                <span style="font-size: 1.125rem; font-weight: 600; color: #059669;">All Systems Operational</span>
            </div>
        </div>

        <!-- System Components -->
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('System Components', 'retail-trade-scanner'); ?>
            </h2>
            
            <div id="system-components" style="display: grid; gap: 1rem;">
                <!-- Components populated by JavaScript -->
            </div>
        </section>

        <!-- Performance Metrics -->
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('Performance Metrics', 'retail-trade-scanner'); ?>
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                
                <!-- Uptime -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Uptime (30 days)', 'retail-trade-scanner'); ?>
                    </div>
                    <div id="uptime-metric" style="font-size: 2.5rem; font-weight: bold; color: #10b981; margin-bottom: 0.5rem;">
                        99.98%
                    </div>
                    <div style="font-size: 0.875rem; color: #64748b;">
                        <?php _e('Target: 99.9%', 'retail-trade-scanner'); ?>
                    </div>
                </div>
                
                <!-- Response Time -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Avg Response Time', 'retail-trade-scanner'); ?>
                    </div>
                    <div id="response-time-metric" style="font-size: 2.5rem; font-weight: bold; color: #10b981; margin-bottom: 0.5rem;">
                        145ms
                    </div>
                    <div style="font-size: 0.875rem; color: #64748b;">
                        <?php _e('Target: <200ms', 'retail-trade-scanner'); ?>
                    </div>
                </div>
                
                <!-- Data Accuracy -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Data Accuracy', 'retail-trade-scanner'); ?>
                    </div>
                    <div id="accuracy-metric" style="font-size: 2.5rem; font-weight: bold; color: #10b981; margin-bottom: 0.5rem;">
                        99.99%
                    </div>
                    <div style="font-size: 0.875rem; color: #64748b;">
                        <?php _e('Real-time feeds', 'retail-trade-scanner'); ?>
                    </div>
                </div>
                
                <!-- Active Users -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); text-align: center;">
                    <div style="font-size: 0.875rem; font-weight: 500; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php _e('Active Users', 'retail-trade-scanner'); ?>
                    </div>
                    <div id="active-users-metric" style="font-size: 2.5rem; font-weight: bold; color: #3b82f6; margin-bottom: 0.5rem;">
                        12,847
                    </div>
                    <div style="font-size: 0.875rem; color: #64748b;">
                        <?php _e('Currently online', 'retail-trade-scanner'); ?>
                    </div>
                </div>
                
            </div>
        </section>

        <!-- Recent Incidents -->
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('Recent Incidents', 'retail-trade-scanner'); ?>
            </h2>
            
            <div id="recent-incidents" style="background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); overflow: hidden;">
                <!-- Incidents populated by JavaScript -->
            </div>
        </section>

        <!-- Maintenance Schedule -->
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 2rem; color: #0f172a;">
                <?php _e('Scheduled Maintenance', 'retail-trade-scanner'); ?>
            </h2>
            
            <div id="maintenance-schedule" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <!-- Maintenance schedule populated by JavaScript -->
            </div>
        </section>

        <!-- Subscribe to Updates -->
        <section style="text-align: center;">
            <div style="background: white; border-radius: 12px; padding: 3rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                <h3 style="font-size: 1.5rem; font-weight: 600; color: #0f172a; margin-bottom: 1rem;">
                    <?php _e('Stay Updated', 'retail-trade-scanner'); ?>
                </h3>
                <p style="color: #64748b; margin-bottom: 2rem;">
                    <?php _e('Get notified about system status updates and scheduled maintenance.', 'retail-trade-scanner'); ?>
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; max-width: 400px; margin: 0 auto;">
                    <input type="email" id="status-email" placeholder="Enter your email" style="flex: 1; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
                    <button id="subscribe-btn" style="background: #059669; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                        <?php _e('Subscribe', 'retail-trade-scanner'); ?>
                    </button>
                </div>
            </div>
        </section>

    </div>
</main>

<script>
// System Status page JavaScript
const systemComponents = [
    { name: 'API Gateway', status: 'operational', uptime: '99.98%', responseTime: '145ms' },
    { name: 'Market Data Feed', status: 'operational', uptime: '99.99%', responseTime: '23ms' },
    { name: 'User Authentication', status: 'operational', uptime: '99.97%', responseTime: '89ms' },
    { name: 'Database Cluster', status: 'operational', uptime: '99.99%', responseTime: '12ms' },
    { name: 'Real-time Notifications', status: 'operational', uptime: '99.95%', responseTime: '156ms' },
    { name: 'File Storage', status: 'operational', uptime: '99.98%', responseTime: '78ms' },
    { name: 'Analytics Engine', status: 'operational', uptime: '99.96%', responseTime: '234ms' },
    { name: 'Email Service', status: 'operational', uptime: '99.94%', responseTime: '445ms' }
];

const recentIncidents = [
    {
        title: 'Brief API Latency Increase',
        description: 'Some users experienced slightly higher response times due to increased market volatility.',
        status: 'resolved',
        date: '2024-01-10',
        duration: '15 minutes',
        impact: 'Minor'
    },
    {
        title: 'Scheduled Database Maintenance',
        description: 'Routine database optimization completed successfully with minimal impact.',
        status: 'resolved',
        date: '2024-01-05',
        duration: '30 minutes',
        impact: 'Minor'
    }
];

const maintenanceSchedule = [
    {
        title: 'Security Updates',
        description: 'Routine security patches and system updates.',
        date: '2024-01-20',
        time: '2:00 AM - 4:00 AM EST',
        impact: 'No expected downtime'
    },
    {
        title: 'Database Optimization',
        description: 'Performance improvements and index optimization.',
        date: '2024-01-25',
        time: '1:00 AM - 3:00 AM EST',
        impact: 'Possible brief interruptions'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    displaySystemComponents();
    displayRecentIncidents();
    displayMaintenanceSchedule();
    setupEventListeners();
    
    // Update metrics every 30 seconds
    setInterval(updateMetrics, 30000);
});

function displaySystemComponents() {
    const container = document.getElementById('system-components');
    
    container.innerHTML = systemComponents.map(component => `
        <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1); display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 12px; height: 12px; background: ${getStatusColor(component.status)}; border-radius: 50%;"></div>
                <div>
                    <h3 style="font-weight: 600; margin: 0; color: #0f172a;">${component.name}</h3>
                    <div style="font-size: 0.875rem; color: #64748b; text-transform: capitalize;">${component.status}</div>
                </div>
            </div>
            <div style="text-align: right; font-size: 0.875rem; color: #64748b;">
                <div>Uptime: <span style="font-weight: 500; color: #0f172a;">${component.uptime}</span></div>
                <div>Response: <span style="font-weight: 500; color: #0f172a;">${component.responseTime}</span></div>
            </div>
        </div>
    `).join('');
}

function displayRecentIncidents() {
    const container = document.getElementById('recent-incidents');
    
    if (recentIncidents.length === 0) {
        container.innerHTML = `
            <div style="padding: 3rem; text-align: center; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                <h3 style="margin-bottom: 0.5rem; color: #0f172a;">No Recent Incidents</h3>
                <p>All systems have been running smoothly.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = recentIncidents.map(incident => `
        <div style="padding: 1.5rem; border-bottom: 1px solid #f1f5f9; last-child:border-bottom: none;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                <h4 style="font-weight: 600; margin: 0; color: #0f172a;">${incident.title}</h4>
                <span style="background: ${getIncidentStatusColor(incident.status)}; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">
                    ${incident.status}
                </span>
            </div>
            <p style="color: #64748b; margin-bottom: 1rem; line-height: 1.5;">${incident.description}</p>
            <div style="display: flex; gap: 2rem; font-size: 0.875rem; color: #64748b;">
                <span><strong>Date:</strong> ${incident.date}</span>
                <span><strong>Duration:</strong> ${incident.duration}</span>
                <span><strong>Impact:</strong> ${incident.impact}</span>
            </div>
        </div>
    `).join('');
}

function displayMaintenanceSchedule() {
    const container = document.getElementById('maintenance-schedule');
    
    if (maintenanceSchedule.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔧</div>
                <h3 style="margin-bottom: 0.5rem; color: #0f172a;">No Scheduled Maintenance</h3>
                <p>No maintenance activities are currently scheduled.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = maintenanceSchedule.map(maintenance => `
        <div style="border-left: 4px solid #3b82f6; padding-left: 1rem; margin-bottom: 2rem; last-child:margin-bottom: 0;">
            <h4 style="font-weight: 600; margin-bottom: 0.5rem; color: #0f172a;">${maintenance.title}</h4>
            <p style="color: #64748b; margin-bottom: 1rem; line-height: 1.5;">${maintenance.description}</p>
            <div style="display: flex; gap: 2rem; font-size: 0.875rem; color: #64748b;">
                <span><strong>Date:</strong> ${maintenance.date}</span>
                <span><strong>Time:</strong> ${maintenance.time}</span>
                <span><strong>Impact:</strong> ${maintenance.impact}</span>
            </div>
        </div>
    `).join('');
}

function setupEventListeners() {
    document.getElementById('subscribe-btn').addEventListener('click', function() {
        const email = document.getElementById('status-email').value;
        if (email) {
            alert('Thank you for subscribing to status updates!');
            document.getElementById('status-email').value = '';
        } else {
            alert('Please enter a valid email address.');
        }
    });
}

function updateMetrics() {
    // Simulate real-time metric updates
    const activeUsers = document.getElementById('active-users-metric');
    if (activeUsers) {
        const currentUsers = parseInt(activeUsers.textContent.replace(',', ''));
        const variation = Math.floor(Math.random() * 200) - 100; // +/- 100 users
        const newUsers = Math.max(1000, currentUsers + variation);
        activeUsers.textContent = newUsers.toLocaleString();
    }
}

function getStatusColor(status) {
    switch (status) {
        case 'operational': return '#10b981';
        case 'degraded': return '#f59e0b';
        case 'outage': return '#ef4444';
        default: return '#64748b';
    }
}

function getIncidentStatusColor(status) {
    switch (status) {
        case 'resolved': return '#10b981';
        case 'investigating': return '#f59e0b';
        case 'ongoing': return '#ef4444';
        default: return '#64748b';
    }
}

// Add pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
`;
document.head.appendChild(style);
</script>

<?php get_footer(); ?>