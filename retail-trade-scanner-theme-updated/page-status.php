<?php
/**
 * Template for System Status page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">System Status</h1>
            <p style="font-size: 1.25rem; color: #64748b;">Real-time system status and performance metrics</p>
        </div>

        <!-- Overall Status -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem; text-align: center;">
            <div id="overall-status" style="display: inline-flex; align-items: center; gap: 1rem; padding: 1rem 2rem; border-radius: 8px; background: #d1fae5; color: #047857;">
                <div style="width: 12px; height: 12px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                <span style="font-weight: 600; font-size: 1.125rem;">All Systems Operational</span>
            </div>
            <p style="color: #64748b; margin-top: 1rem; margin-bottom: 0;">Last updated: <span id="last-updated">Loading...</span></p>
        </div>

        <!-- System Components -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">System Components</h2>
            
            <div id="system-components" style="display: grid; gap: 1rem;">
                <!-- Components will be populated by JavaScript -->
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">Performance Metrics</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Response Time</div>
                    <div id="response-time" style="font-size: 2rem; font-weight: bold; color: #059669;">Loading...</div>
                </div>
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Uptime (30 days)</div>
                    <div id="uptime" style="font-size: 2rem; font-weight: bold; color: #059669;">Loading...</div>
                </div>
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">API Requests/min</div>
                    <div id="api-requests" style="font-size: 2rem; font-weight: bold; color: #0f172a;">Loading...</div>
                </div>
                <div style="text-align: center; padding: 1rem;">
                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Data Latency</div>
                    <div id="data-latency" style="font-size: 2rem; font-weight: bold; color: #059669;">Loading...</div>
                </div>
            </div>
        </div>

        <!-- Incidents -->
        <div class="card" style="padding: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">Recent Incidents</h2>
            
            <div id="incidents-container">
                <!-- Incidents will be populated by JavaScript -->
            </div>
        </div>
    </div>
</main>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSystemStatus();
    
    // Auto-refresh every 30 seconds
    setInterval(loadSystemStatus, 30000);
});

function loadSystemStatus() {
    updateLastUpdated();
    loadSystemComponents();
    loadPerformanceMetrics();
    loadIncidents();
}

function updateLastUpdated() {
    document.getElementById('last-updated').textContent = new Date().toLocaleString();
}

function loadSystemComponents() {
    // Simulate API call to get system status
    const components = [
        { name: 'API Gateway', status: 'operational', description: 'Processing requests normally' },
        { name: 'Market Data Feed', status: 'operational', description: 'Real-time data flowing' },
        { name: 'Database', status: 'operational', description: 'All queries responding' },
        { name: 'Authentication', status: 'operational', description: 'Login systems active' },
        { name: 'Notifications', status: 'operational', description: 'Email alerts working' },
        { name: 'File Storage', status: 'operational', description: 'Document access normal' }
    ];
    
    const container = document.getElementById('system-components');
    
    container.innerHTML = components.map(component => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px;">
            <div>
                <div style="font-weight: 600; margin-bottom: 0.25rem;">${component.name}</div>
                <div style="color: #64748b; font-size: 0.875rem;">${component.description}</div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 8px; height: 8px; background: ${getStatusColor(component.status)}; border-radius: 50%;"></div>
                <span style="color: ${getStatusTextColor(component.status)}; font-weight: 500; font-size: 0.875rem; text-transform: capitalize;">
                    ${component.status}
                </span>
            </div>
        </div>
    `).join('');
}

function loadPerformanceMetrics() {
    // Simulate performance metrics
    document.getElementById('response-time').textContent = '89ms';
    document.getElementById('uptime').textContent = '99.97%';
    document.getElementById('api-requests').textContent = '1,247';
    document.getElementById('data-latency').textContent = '<2min';
}

function loadIncidents() {
    const container = document.getElementById('incidents-container');
    
    // Simulate no recent incidents
    container.innerHTML = `
        <div style="text-align: center; padding: 3rem; color: #64748b;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No Recent Incidents</h3>
            <p>All systems have been running smoothly. No incidents reported in the last 30 days.</p>
        </div>
    `;
}

function getStatusColor(status) {
    switch (status) {
        case 'operational': return '#10b981';
        case 'degraded': return '#f59e0b';
        case 'outage': return '#ef4444';
        case 'maintenance': return '#6366f1';
        default: return '#6b7280';
    }
}

function getStatusTextColor(status) {
    switch (status) {
        case 'operational': return '#047857';
        case 'degraded': return '#92400e';
        case 'outage': return '#dc2626';
        case 'maintenance': return '#4338ca';
        default: return '#374151';
    }
}
</script>

<?php get_footer(); ?>