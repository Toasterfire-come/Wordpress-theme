<?php
/**
 * Template for Billing History page
 * Retail Trade Scanner - Billing and payment history
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Billing History</h1>
            <p style="font-size: 1.25rem; color: #64748b;">View and download your payment history and invoices</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            
            <!-- Billing Summary -->
            <div>
                <div class="card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Current Plan</h2>
                    
                    <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                        <div style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Pro Plan</div>
                        <div style="color: #1d4ed8; font-size: 0.875rem; margin-bottom: 0.5rem;">$49.99/month</div>
                        <div style="color: #1d4ed8; font-size: 0.875rem;">Next billing: March 15, 2024</div>
                    </div>
                    
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-outline" style="width: 100%; justify-content: center;">
                        Manage Plan
                    </a>
                </div>

                <div class="card" style="padding: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Billing Stats</h2>
                    
                    <div id="billing-stats" style="display: grid; gap: 1rem;">
                        <!-- Stats will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Billing History -->
            <div class="card" style="padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Payment History</h2>
                    <div style="display: flex; gap: 1rem;">
                        <select id="year-filter" style="padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px;">
                            <option value="all">All Years</option>
                            <option value="2024" selected>2024</option>
                            <option value="2023">2023</option>
                        </select>
                        <button id="export-csv" class="btn btn-outline" style="padding: 0.5rem 1rem;">
                            📄 Export CSV
                        </button>
                    </div>
                </div>

                <div id="billing-history-table" style="overflow-x: auto;">
                    <!-- Table will be populated by JavaScript -->
                </div>

                <div id="pagination" style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem;">
                    <!-- Pagination will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadBillingHistory();
    loadBillingStats();
    
    // Event listeners
    document.getElementById('year-filter').addEventListener('change', function() {
        loadBillingHistory(this.value);
    });
    
    document.getElementById('export-csv').addEventListener('click', function() {
        exportBillingHistory();
    });
});

function loadBillingHistory(year = '2024') {
    // Mock billing history data
    const billingData = [
        {
            id: 'INV-2024-003',
            date: '2024-02-15',
            description: 'Pro Plan Subscription - February 2024',
            amount: 49.99,
            status: 'Paid',
            method: 'Visa •••• 4567',
            downloadUrl: '#'
        },
        {
            id: 'INV-2024-002',
            date: '2024-01-15',
            description: 'Pro Plan Subscription - January 2024',
            amount: 49.99,
            status: 'Paid',
            method: 'Visa •••• 4567',
            downloadUrl: '#'
        },
        {
            id: 'INV-2024-001',
            date: '2024-01-01',
            description: 'Plan Upgrade - Basic to Pro',
            amount: 25.00,
            status: 'Paid',
            method: 'Visa •••• 4567',
            downloadUrl: '#'
        },
        {
            id: 'INV-2023-012',
            date: '2023-12-15',
            description: 'Basic Plan Subscription - December 2023',
            amount: 24.99,
            status: 'Paid',
            method: 'Visa •••• 4567',
            downloadUrl: '#'
        },
        {
            id: 'INV-2023-011',
            date: '2023-11-15',
            description: 'Basic Plan Subscription - November 2023',
            amount: 24.99,
            status: 'Paid',
            method: 'Visa •••• 4567',
            downloadUrl: '#'
        }
    ];
    
    // Filter by year if specified
    let filteredData = billingData;
    if (year !== 'all') {
        filteredData = billingData.filter(item => item.date.startsWith(year));
    }
    
    const container = document.getElementById('billing-history-table');
    
    if (filteredData.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
                <div style="font-size: 1.125rem; font-weight: 500; margin-bottom: 0.5rem;">No billing history found</div>
                <div style="font-size: 0.875rem;">No payments found for the selected time period.</div>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #e5e7eb;">
                    <th style="text-align: left; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Invoice</th>
                    <th style="text-align: left; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Date</th>
                    <th style="text-align: left; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Description</th>
                    <th style="text-align: right; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Amount</th>
                    <th style="text-align: center; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Status</th>
                    <th style="text-align: center; padding: 1rem 0.5rem; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                ${filteredData.map(item => `
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem 0.5rem; font-weight: 500; color: #1f2937;">${item.id}</td>
                        <td style="padding: 1rem 0.5rem; color: #6b7280;">${new Date(item.date).toLocaleDateString()}</td>
                        <td style="padding: 1rem 0.5rem; color: #374151;">
                            <div style="font-weight: 500; margin-bottom: 0.25rem;">${item.description.split(' - ')[0]}</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">${item.method}</div>
                        </td>
                        <td style="padding: 1rem 0.5rem; text-align: right; font-weight: 600; color: #1f2937;">$${item.amount.toFixed(2)}</td>
                        <td style="padding: 1rem 0.5rem; text-align: center;">
                            <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 500;">
                                ${item.status}
                            </span>
                        </td>
                        <td style="padding: 1rem 0.5rem; text-align: center;">
                            <button onclick="downloadInvoice('${item.id}')" class="btn btn-outline" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">
                                📄 Download
                            </button>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

function loadBillingStats() {
    const container = document.getElementById('billing-stats');
    const stats = [
        { label: 'Total Paid', value: '$174.96', color: '#059669', icon: '💰' },
        { label: 'This Year', value: '$124.98', color: '#2563eb', icon: '📅' },
        { label: 'Last Payment', value: '$49.99', color: '#7c3aed', icon: '💳' },
        { label: 'Next Bill', value: 'Mar 15', color: '#dc2626', icon: '🔔' }
    ];
    
    container.innerHTML = stats.map(stat => `
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 6px;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.25rem;">${stat.icon}</span>
                <span style="font-size: 0.875rem; color: #64748b;">${stat.label}</span>
            </div>
            <span style="font-weight: 600; color: ${stat.color};">${stat.value}</span>
        </div>
    `).join('');
}

function downloadInvoice(invoiceId) {
    // Simulate invoice download
    showNotification(`Downloading invoice ${invoiceId}`, 'success');
    
    // In a real implementation, this would call the backend API
    fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/download/')); ?>${invoiceId}`, {
        method: 'GET',
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Download failed');
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `${invoiceId}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Download error:', error);
        showNotification('Failed to download invoice', 'error');
    });
}

function exportBillingHistory() {
    const year = document.getElementById('year-filter').value;
    showNotification(`Exporting billing history for ${year === 'all' ? 'all years' : year}`, 'success');
    
    // Mock CSV export
    const csvContent = `Invoice ID,Date,Description,Amount,Status,Payment Method
INV-2024-003,2024-02-15,Pro Plan Subscription,49.99,Paid,Visa •••• 4567
INV-2024-002,2024-01-15,Pro Plan Subscription,49.99,Paid,Visa •••• 4567
INV-2024-001,2024-01-01,Plan Upgrade,25.00,Paid,Visa •••• 4567`;
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `billing-history-${year}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        z-index: 1000;
        max-width: 300px;
        font-weight: 500;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    `;
    
    notification.style.backgroundColor = type === 'success' ? '#059669' : '#dc2626';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<?php get_footer(); ?>