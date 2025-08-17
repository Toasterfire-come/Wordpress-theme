(function(){
	if (!window.React || !window.ReactDOM) {
		console.error('React or ReactDOM not found.');
		return;
	}
	var e = React.createElement;

	function Header(){
		return e('header', { className: 'site-header' },
			e('div', { className: 'header-content' },
				e('div', { className: 'header-main' },
					e('div', { className: 'header-left' },
						e('a', { href: '/', className: 'logo' },
							e('div', { className: 'logo-icon' },
								e('svg', { width: 20, height: 20, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2 },
									e('polyline', { points: '23 6 13.5 15.5 8.5 10.5 1 18' }),
									e('polyline', { points: '17 6 23 6 23 12' })
								)
							),
							e('div', { className: 'logo-text' },
								e('h1', null, 'StockScan Pro'),
								e('p', null, 'Professional Stock Analysis')
							)
						)
					),
					e('div', { className: 'header-actions' },
						e('div', { className: 'market-status' },
							e('div', { className: 'market-label' }, 'S&P 500'),
							e('div', { className: 'market-value' },
								e('span', { style: { color: 'var(--emerald-400)', fontWeight: 500, fontSize: '0.875rem' } }, '+0.52%'),
								e('span', { className: 'live-badge' }, 'LIVE')
							)
						)
					)
				)
			),
			e('nav', { className: 'full-nav' },
				e('ul', { className: 'nav-list' },
					e('li', { className: 'nav-item' }, e('a', { href: '/dashboard' }, 'Dashboard')),
					e('li', { className: 'nav-item' }, e('a', { href: '/market-overview' }, 'Markets')),
					e('li', { className: 'nav-item' }, e('a', { href: '/stock-scanner' }, 'Scanner')),
					e('li', { className: 'nav-item' }, e('a', { href: '/watchlist' }, 'Watchlist')),
					e('li', { className: 'nav-item' }, e('a', { href: '/news' }, 'News'))
				)
			)
		);
	}

	function Footer(){
		var year = new Date().getFullYear();
		return e('footer', { className: 'site-footer' },
			e('div', { className: 'footer-content' },
				e('div', { className: 'footer-grid' },
					e('div', null,
						e('a', { href: '/', className: 'footer-brand' },
							e('div', { className: 'footer-brand-icon' },
								e('svg', { width: 20, height: 20, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2 },
									e('polyline', { points: '23 6 13.5 15.5 8.5 10.5 1 18' }),
									e('polyline', { points: '17 6 23 6 23 12' })
								)
							),
							e('div', { className: 'footer-brand-text' },
								e('h3', null, 'StockScan Pro'),
								e('p', null, 'Professional Stock Analysis')
							)
						),
						e('p', { className: 'footer-description' }, 'Advanced stock scanning and market analysis tools for professional traders and investors.')
					),
					e('div', { className: 'footer-section' },
						e('h4', null, 'Quick Links'),
						e('ul', { className: 'footer-links' },
							e('li', null, e('a', { href: '/dashboard' }, 'Dashboard')),
							e('li', null, e('a', { href: '/stock-scanner' }, 'Stock Scanner')),
							e('li', null, e('a', { href: '/market-overview' }, 'Market Overview')),
							e('li', null, e('a', { href: '/watchlist' }, 'Watchlist')),
							e('li', null, e('a', { href: '/news' }, 'Market News'))
						)
					),
					e('div', { className: 'footer-section' },
						e('h4', null, 'Legal'),
						e('ul', { className: 'footer-links' },
							e('li', null, e('a', { href: '/terms' }, 'Terms of Service')),
							e('li', null, e('a', { href: '/privacy' }, 'Privacy Policy')),
							e('li', null, e('a', { href: '/security' }, 'Security')),
							e('li', null, e('a', { href: '/accessibility' }, 'Accessibility')),
							e('li', null, e('a', { href: '/contact' }, 'Contact'))
						)
					)
				),
				e('div', { className: 'footer-bottom' },
					e('div', { className: 'footer-copyright' }, '© ' + year + ' StockScan Pro. All rights reserved. Market data provided by third-party sources.')
				)
			)
		);
	}

	function App(){
		return e(React.Fragment, null,
			e('div', { className: 'app-container' },
				e('div', { className: 'main-content-area' },
					e(Header, null),
					e('main', { className: 'main-content' },
						e('div', { className: 'page-content' },
							e('div', { className: 'card' },
								e('h2', null, 'Welcome to StockScan Pro'),
								e('p', null, 'This UI is now rendered fully by React.')
							)
						)
					)
				)
			),
			e(Footer, null)
		);
	}

	var rootEl = document.getElementById('app-root');
	if (!rootEl) { return; }
	if (ReactDOM.createRoot) {
		var root = ReactDOM.createRoot(rootEl);
		root.render(e(App));
	} else {
		ReactDOM.render(e(App), rootEl);
	}
})();