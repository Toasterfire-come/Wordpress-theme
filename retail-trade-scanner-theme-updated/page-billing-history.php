<?php
/**
 * Template for Billing History page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="min-height: 100vh; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 3rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">Billing History</h1>
            <p style="font-size: 1.25rem; color: #64748b;">View and download your billing statements and invoices</p>
        </div>

        <!-- Billing Summary -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Current Plan</div>
                <div id="current-plan" style="font-size: 1.5rem; font-weight: bold; color: #0f172a;">Loading...</div>
            </div>
            <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Next Billing</div>
                <div id="next-billing" style="font-size: 1.5rem; font-weight: bold; color: #0f172a;">Loading...</div>
            </div>
            <div class="card" style="padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem;">Total Paid</div>
                <div id="total-paid" style="font-size: 1.5rem; font-weight: bold; color: #059669;">Loading...</div>
            </div>
        </div>

        <!-- Billing History Table -->
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0;">Billing History</h2>
                <div style="display: flex; gap: 1rem;">
                    <select id="filter-period" style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                        <option value="all">All Time</option>
                        <option value="12">Last 12 Months</option>
                        <option value="6">Last 6 Months</option>
                        <option value="3">Last 3 Months</option>
                    </select>
                    <button id="export-csv" class="btn btn-outline">Export CSV</button>
                </div>
            </div>
            
            <div id="billing-table-container">
                <!-- Billing table will be populated by JavaScript -->
            </div>
            
            <div id="no-billing-data" style="display: none; text-align: center; padding: 3rem; color: #64748b;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💳</div>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No Billing History</h3>
                <p>You haven't been billed yet. Your billing history will appear here once you have transactions.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="text-align: center; margin-top: 3rem;">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('account'))); ?>" class="btn btn-outline" style="margin-right: 1rem;">
                ← Back to Account
            </a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('premium-plans'))); ?>" class="btn btn-primary">
                Manage Plan
            </a>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadBillingSummary();
    loadBillingHistory();
    
    // Filter change handler
    document.getElementById('filter-period').addEventListener('change', function() {
        loadBillingHistory(this.value);
    });
    
    // Export CSV handler
    document.getElementById('export-csv').addEventListener('click', function() {
        exportBillingHistory();
    });
});

function loadBillingSummary() {
    fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/summary')); ?>', {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            const summary = data.data;
            document.getElementById('current-plan').textContent = summary.current_plan || 'Free Plan';
            document.getElementById('next-billing').textContent = summary.next_billing || 'N/A';
            document.getElementById('total-paid').textContent = summary.total_paid || '$0.00';
        }
    })
    .catch(error => {
        console.error('Error loading billing summary:', error);
        // Set defaults
        document.getElementById('current-plan').textContent = 'Free Plan';
        document.getElementById('next-billing').textContent = 'N/A';
        document.getElementById('total-paid').textContent = '$0.00';
    });
}

function loadBillingHistory(period = 'all') {
    fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/history')); ?>?period=${period}`, {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data && data.data.length > 0) {
            renderBillingTable(data.data);
            document.getElementById('no-billing-data').style.display = 'none';
        } else {
            document.getElementById('billing-table-container').innerHTML = '';
            document.getElementById('no-billing-data').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error loading billing history:', error);
        document.getElementById('billing-table-container').innerHTML = '';
        document.getElementById('no-billing-data').style.display = 'block';
    });
}

function renderBillingTable(billingData) {
    const container = document.getElementById('billing-table-container');
    
    container.innerHTML = `
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Date</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Description</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Amount</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Status</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600; color: #374151;">Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    ${billingData.map(item => `
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem; color: #374151;">${formatDate(item.date)}</td>
                            <td style="padding: 1rem; color: #374151;">
                                <div style="font-weight: 500;">${item.description || 'Subscription'}</div>
                                <div style="font-size: 0.875rem; color: #64748b;">${item.plan || ''}</div>
                            </td>
                            <td style="padding: 1rem; font-weight: 600; color: #374151;">${item.amount}</td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 500; 
                                     background: ${getStatusColor(item.status).bg}; color: ${getStatusColor(item.status).text};">
                                    ${item.status}
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                ${item.invoice_url ? `
                                    <a href="${item.invoice_url}" target="_blank" class="btn btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        Download
                                    </a>
                                ` : `
                                    <button onclick="downloadInvoice('${item.id}')" class="btn btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        Download
                                    </button>
                                `}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function formatDate(dateString) {
    try {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch {
        return dateString;
    }
}

function getStatusColor(status) {
    switch (status?.toLowerCase()) {
        case 'paid':
            return { bg: '#d1fae5', text: '#047857' };
        case 'pending':
            return { bg: '#fef3c7', text: '#92400e' };
        case 'failed':
            return { bg: '#fee2e2', text: '#dc2626' };
        default:
            return { bg: '#f3f4f6', text: '#374151' };
    }
}

function downloadInvoice(invoiceId) {
    fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/invoice')); ?>/${invoiceId}`, {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        } else {
            throw new Error('Failed to download invoice');
        }
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `invoice-${invoiceId}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        console.error('Error downloading invoice:', error);
        showNotification('Failed to download invoice', 'error');
    });
}

function exportBillingHistory() {
    const period = document.getElementById('filter-period').value;
    
    fetch(`<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/billing/export')); ?>?period=${period}&format=csv`, {
        headers: {
            'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        } else {
            throw new Error('Failed to export billing history');
        }
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `billing-history-${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        showNotification('Billing history exported successfully', 'success');
    })
    .catch(error => {
        console.error('Error exporting billing history:', error);
        showNotification('Failed to export billing history', 'error');
    });
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
    `;
    
    notification.style.backgroundColor = type === 'success' ? '#059669' : '#dc2626';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

<?php get_footer(); ?>