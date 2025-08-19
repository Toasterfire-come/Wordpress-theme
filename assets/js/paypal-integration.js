// PayPal Integration for Retail Trade Scanner - Production Ready
// Enhanced error handling and user experience

(function() {
    'use strict';

    // PayPal Integration Manager
    window.PayPalIntegration = {
        clientId: null,
        isInitialized: false,
        buttons: {},
        
        init: function() {
            // Check if PayPal SDK is loaded
            if (typeof paypal === 'undefined') {
                console.warn('PayPal SDK not loaded');
                this.showFallbackButtons();
                return;
            }
            
            // Get client ID from localized data
            this.clientId = window.retail_trade_scanner_data?.paypal_client_id;
            
            if (!this.clientId) {
                console.warn('PayPal Client ID not configured');
                this.showFallbackButtons();
                return;
            }
            
            this.isInitialized = true;
            this.initializeButtons();
        },
        
        initializeButtons: function() {
            // Find all payment button containers
            const buttonContainers = [
                { id: 'bronze-payment-button', level: 2, price: 14.99, plan: 'Bronze' },
                { id: 'silver-payment-button', level: 3, price: 29.99, plan: 'Silver' },
                { id: 'gold-payment-button', level: 4, price: 59.99, plan: 'Gold' }
            ];
            
            buttonContainers.forEach(container => {
                const element = document.getElementById(container.id);
                if (element) {
                    this.renderPayPalButton(container.id, container);
                }
            });
        },
        
        renderPayPalButton: function(containerId, config) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // Clear existing content
            container.innerHTML = '';
            
            try {
                this.buttons[containerId] = paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        color: 'blue',
                        shape: 'rect',
                        label: 'paypal',
                        height: 40
                    },
                    
                    createOrder: (data, actions) => {
                        return this.createOrder(actions, config);
                    },
                    
                    onApprove: (data, actions) => {
                        return this.onApprove(data, actions, config);
                    },
                    
                    onError: (err) => {
                        this.onError(err, config);
                    },
                    
                    onCancel: (data) => {
                        this.onCancel(data, config);
                    }
                });
                
                // Render button
                if (this.buttons[containerId].isEligible()) {
                    this.buttons[containerId].render(`#${containerId}`);
                } else {
                    this.showFallbackButton(container, config);
                }
                
            } catch (error) {
                console.error('PayPal button render error:', error);
                this.showFallbackButton(container, config);
            }
        },
        
        createOrder: function(actions, config) {
            // Check if user is logged in
            if (!window.retail_trade_scanner_data?.is_user_logged_in) {
                this.showNotification('Please log in to upgrade your plan', 'warning');
                return Promise.reject(new Error('User not logged in'));
            }
            
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: config.price.toString(),
                        currency_code: 'USD'
                    },
                    description: `Retail Trade Scanner ${config.plan} Plan - Monthly Subscription`,
                    custom_id: `rts_${config.level}_${Date.now()}`,
                    invoice_id: `RTS-${config.plan.toUpperCase()}-${Date.now()}`
                }],
                application_context: {
                    brand_name: 'Retail Trade Scanner',
                    locale: 'en-US',
                    landing_page: 'BILLING',
                    shipping_preference: 'NO_SHIPPING',
                    user_action: 'PAY_NOW'
                }
            });
        },
        
        onApprove: function(data, actions, config) {
            this.showNotification('Processing payment...', 'info');
            
            return actions.order.capture().then((details) => {
                // Send order details to backend for processing
                return this.processSubscription(details, config);
            });
        },
        
        processSubscription: function(orderDetails, config) {
            const subscriptionData = {
                order_id: orderDetails.id,
                payer: orderDetails.payer,
                level: config.level,
                plan: config.plan,
                amount: config.price,
                status: orderDetails.status
            };
            
            return fetch(window.retail_trade_scanner_data?.rest_url + 'paypal/process-subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': window.retail_trade_scanner_data?.nonce
                },
                body: JSON.stringify(subscriptionData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.onSubscriptionSuccess(config, orderDetails);
                } else {
                    throw new Error(data.message || 'Subscription processing failed');
                }
            })
            .catch(error => {
                console.error('Subscription processing error:', error);
                this.onSubscriptionError(error, config);
            });
        },
        
        onSubscriptionSuccess: function(config, orderDetails) {
            this.showNotification(`Welcome to ${config.plan} Plan! Your subscription is now active.`, 'success');
            
            // Redirect to success page or dashboard
            setTimeout(() => {
                const successUrl = '/membership-confirmation/?order=' + orderDetails.id + '&plan=' + config.plan.toLowerCase();
                window.location.href = successUrl;
            }, 2000);
        },
        
        onSubscriptionError: function(error, config) {
            this.showNotification(
                `Subscription activation failed: ${error.message}. Please contact support if the issue persists.`, 
                'error'
            );
        },
        
        onError: function(err, config) {
            console.error('PayPal error:', err);
            
            let errorMessage = 'Payment failed. Please try again.';
            
            // Handle specific PayPal errors
            if (err.message) {
                if (err.message.includes('INSTRUMENT_DECLINED')) {
                    errorMessage = 'Your payment method was declined. Please try a different payment method.';
                } else if (err.message.includes('PAYER_CANNOT_PAY')) {
                    errorMessage = 'Payment cannot be processed. Please check your PayPal account status.';
                } else if (err.message.includes('PAYEE_BLOCKED')) {
                    errorMessage = 'Payment processing is temporarily unavailable. Please try again later.';
                }
            }
            
            this.showNotification(errorMessage, 'error');
        },
        
        onCancel: function(data, config) {
            this.showNotification('Payment was cancelled. No charges were made.', 'info');
            console.log('PayPal payment cancelled:', data);
        },
        
        showFallbackButtons: function() {
            const buttonContainers = ['bronze-payment-button', 'silver-payment-button', 'gold-payment-button'];
            const configs = [
                { level: 2, price: 14.99, plan: 'Bronze' },
                { level: 3, price: 29.99, plan: 'Silver' },
                { level: 4, price: 59.99, plan: 'Gold' }
            ];
            
            buttonContainers.forEach((containerId, index) => {
                const container = document.getElementById(containerId);
                if (container) {
                    this.showFallbackButton(container, configs[index]);
                }
            });
        },
        
        showFallbackButton: function(container, config) {
            container.innerHTML = `
                <div style="text-align: center; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb;">
                    <p style="font-size: 0.875rem; color: #64748b; margin-bottom: 1rem;">
                        PayPal integration not available
                    </p>
                    <button class="btn btn-primary fallback-upgrade-btn" data-level="${config.level}" data-price="${config.price}" data-plan="${config.plan}" style="width: 100%;">
                        Upgrade to ${config.plan} - $${config.price}/month
                    </button>
                </div>
            `;
            
            // Add click handler for fallback button
            const fallbackBtn = container.querySelector('.fallback-upgrade-btn');
            if (fallbackBtn) {
                fallbackBtn.addEventListener('click', () => {
                    this.handleFallbackUpgrade(config);
                });
            }
        },
        
        handleFallbackUpgrade: function(config) {
            if (!window.retail_trade_scanner_data?.is_user_logged_in) {
                this.showNotification('Please log in to upgrade your plan', 'warning');
                setTimeout(() => {
                    window.location.href = '/wp-login.php?redirect_to=' + encodeURIComponent(window.location.href);
                }, 1500);
                return;
            }
            
            // Check if plugin is active
            if (window.retail_trade_scanner_data?.plugin_active) {
                // Redirect to plugin checkout if available
                if (typeof window.pmpro_url === 'function') {
                    window.location.href = window.pmpro_url('checkout', '?level=' + config.level);
                } else {
                    window.location.href = '/membership-checkout/?level=' + config.level;
                }
            } else {
                this.showNotification('Stock Scanner Plugin required for subscription management.', 'error');
            }
        },
        
        // Utility methods
        showNotification: function(message, type = 'info') {
            if (window.RetailTradeScanner && window.RetailTradeScanner.notify) {
                window.RetailTradeScanner.notify(message, type);
            } else if (window.showNotification) {
                window.showNotification(message, type);
            } else {
                // Fallback notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed; top: 20px; right: 20px; padding: 1rem 1.5rem;
                    border-radius: 8px; color: white; z-index: 10000; font-weight: 500;
                    background: ${this.getNotificationColor(type)};
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                    transform: translateX(100%); transition: transform 0.3s ease;
                `;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                // Animate in
                requestAnimationFrame(() => {
                    notification.style.transform = 'translateX(0)';
                });
                
                // Auto-remove
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 5000);
            }
        },
        
        getNotificationColor: function(type) {
            switch (type) {
                case 'success': return '#059669';
                case 'error': return '#dc2626';
                case 'warning': return '#d97706';
                default: return '#2563eb';
            }
        },
        
        // Public methods
        refresh: function() {
            if (this.isInitialized) {
                this.initializeButtons();
            } else {
                this.init();
            }
        },
        
        destroy: function() {
            // Clean up PayPal buttons
            Object.keys(this.buttons).forEach(containerId => {
                if (this.buttons[containerId] && typeof this.buttons[containerId].close === 'function') {
                    this.buttons[containerId].close();
                }
            });
            this.buttons = {};
            this.isInitialized = false;
        }
    };
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            window.PayPalIntegration.init();
        });
    } else {
        window.PayPalIntegration.init();
    }
    
    // Re-initialize if PayPal SDK loads after page load
    window.addEventListener('load', () => {
        if (typeof paypal !== 'undefined' && !window.PayPalIntegration.isInitialized) {
            window.PayPalIntegration.init();
        }
    });
    
})();