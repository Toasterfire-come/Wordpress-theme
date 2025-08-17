(function(){
	if (!window.React || !window.ReactDOM) {
		console.error('React or ReactDOM not found.');
		return;
	}
	var e = React.createElement;
	var useState = React.useState;
	var useEffect = React.useEffect;
	var useMemo = React.useMemo;

	var Config = window.StockScan || {};
	var WP_REST_BASE = '/wp-json/stock-scanner/v1';

	function isInternalHref(href){
		try { var u = new URL(href, window.location.origin); return u.origin === window.location.origin; } catch (err) { return false; }
	}
	function navigate(path, replace){
		if (replace) { history.replaceState({}, '', path); }
		else { history.pushState({}, '', path); }
		window.dispatchEvent(new Event('popstate'));
	}
	window.AppNavigate = navigate;

	function ajax(action, payload){
		var url = (Config && Config.ajax_url) || '/wp-admin/admin-ajax.php';
		var nonce = (Config && Config.nonce) || '';
		var data = new FormData();
		data.append('action', action);
		if (nonce) data.append('nonce', nonce);
		Object.keys(payload||{}).forEach(function(k){ data.append(k, payload[k]); });
		return fetch(url, { method: 'POST', body: data })
			.then(function(r){ return r.json(); })
			.catch(function(err){ return { error: err && err.message ? err.message : 'Network error' }; });
	}
	function rest(path){
		return fetch(WP_REST_BASE + path, { headers: { 'Accept': 'application/json' } })
			.then(function(r){ return r.json(); })
			.catch(function(err){ return { error: err && err.message ? err.message : 'Network error' }; });
	}

	function useAsync(effectDeps, loader){
		var _a = useState({ loading: true, data: null, error: null }), state = _a[0], setState = _a[1];
		useEffect(function(){
			var alive = true;
			setState({ loading: true, data: null, error: null });
			Promise.resolve().then(loader).then(function(data){ if (alive) setState({ loading: false, data: data, error: null }); })
				.catch(function(err){ if (alive) setState({ loading: false, data: null, error: err && err.message ? err.message : 'Error' }); });
			return function(){ alive = false; };
		}, effectDeps);
		return state;
	}

	function SectionCard(props){
		return e('div', { className: 'card' },
			props.title ? e('h3', null, props.title) : null,
			props.children
		);
	}
	function Loading(){ return e('div', { className: 'card' }, 'Loading…'); }
	function ErrorBox(props){ return e('div', { className: 'card' }, e('strong', { style: { color: '#b00' } }, 'Error: '), props.message || 'Something went wrong'); }

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

	function JsonBlock(props){
		return e('pre', { style: { overflow: 'auto', background: '#f8fafc', border: '1px solid #e2e8f0', padding: '0.75rem', borderRadius: '0.5rem' } }, JSON.stringify(props.data, null, 2));
	}

	// Views
	function HomeView(){
		return e(SectionCard, { title: 'Welcome to StockScan Pro' },
			e('p', null, 'Advanced stock scanning and market analysis tools for professional traders and investors.'),
			e('div', { style: { display: 'flex', gap: '1rem', marginTop: '1rem' } },
				e('a', { href: '/dashboard', className: 'btn' }, 'Go to Dashboard'),
				e('a', { href: '/stock-scanner', className: 'btn secondary' }, 'Try Stock Scanner')
			)
		);
	}

	function DashboardView(){
		var portfolio = useAsync([], function(){ return ajax('get_formatted_portfolio_data'); });
		var watchlist = useAsync([], function(){ return ajax('get_formatted_watchlist_data'); });
		var market = useAsync([], function(){ return rest('/market-data'); });
		var news = useAsync([], function(){ return rest('/news?limit=5'); });
		if (portfolio.loading || watchlist.loading || market.loading || news.loading) return e(Loading);
		if (portfolio.error || watchlist.error || market.error || news.error) return e(ErrorBox, { message: portfolio.error || watchlist.error || market.error || news.error });
		return e(React.Fragment, null,
			e(SectionCard, { title: 'Portfolio' }, e(JsonBlock, { data: portfolio.data })),
			e(SectionCard, { title: 'Watchlist' }, e(JsonBlock, { data: watchlist.data })),
			e(SectionCard, { title: 'Market' }, e(JsonBlock, { data: market.data })),
			e(SectionCard, { title: 'News' }, e(JsonBlock, { data: news.data }))
		);
	}

	function MarketOverviewView(){
		var indices = useAsync([], function(){ return ajax('get_major_indices'); });
		var gainers = useAsync([], function(){ return ajax('get_market_movers', { category: 'gainers' }); });
		var losers = useAsync([], function(){ return ajax('get_market_movers', { category: 'losers' }); });
		var active = useAsync([], function(){ return ajax('get_market_movers', { category: 'active' }); });
		if (indices.loading || gainers.loading || losers.loading || active.loading) return e(Loading);
		if (indices.error || gainers.error || losers.error || active.error) return e(ErrorBox, { message: indices.error || gainers.error || losers.error || active.error });
		return e(React.Fragment, null,
			e(SectionCard, { title: 'Major Indices' }, e(JsonBlock, { data: indices.data })),
			e(SectionCard, { title: 'Top Gainers' }, e(JsonBlock, { data: gainers.data })),
			e(SectionCard, { title: 'Top Losers' }, e(JsonBlock, { data: losers.data })),
			e(SectionCard, { title: 'Most Active' }, e(JsonBlock, { data: active.data }))
		);
	}

	function WatchlistView(){
		var wl = useAsync([], function(){ return ajax('get_formatted_watchlist_data'); });
		if (wl.loading) return e(Loading);
		if (wl.error) return e(ErrorBox, { message: wl.error });
		return e(SectionCard, { title: 'Watchlist' }, e(JsonBlock, { data: wl.data }));
	}
	function PortfolioView(){
		var pf = useAsync([], function(){ return ajax('get_formatted_portfolio_data'); });
		if (pf.loading) return e(Loading);
		if (pf.error) return e(ErrorBox, { message: pf.error });
		return e(SectionCard, { title: 'Portfolio' }, e(JsonBlock, { data: pf.data }));
	}

	function NewsView(){
		var data = useAsync([], function(){ return rest('/news?limit=12'); });
		if (data.loading) return e(Loading);
		if (data.error) return e(ErrorBox, { message: data.error });
		return e(SectionCard, { title: 'Market News' }, e(JsonBlock, { data: data.data }));
	}

	function StockScannerView(){
		var _a = useState(''), symbol = _a[0], setSymbol = _a[1];
		var _b = useState(null), quote = _b[0], setQuote = _b[1];
		var _c = useState(null), usage = _c[0], setUsage = _c[1];
		var _d = useState(false), loading = _d[0], setLoading = _d[1];
		var onSubmit = function(ev){ ev.preventDefault(); if (!symbol) return; setLoading(true); ajax('stock_scanner_get_quote', { symbol: symbol }).then(function(resp){ setQuote(resp); return ajax('get_usage_stats'); }).then(function(u){ setUsage(u); }).finally(function(){ setLoading(false); }); };
		return e(React.Fragment, null,
			e(SectionCard, { title: 'Stock Scanner' },
				e('form', { onSubmit: onSubmit, style: { display: 'flex', gap: '0.5rem', alignItems: 'center' } },
					e('input', { className: 'form-control', placeholder: 'Enter symbol (e.g., AAPL)', value: symbol, onChange: function(ev){ setSymbol(ev.target.value); }, style: { maxWidth: '240px' } }),
					e('button', { className: 'btn', type: 'submit', disabled: loading }, loading ? 'Loading…' : 'Get Quote')
				)
			),
			quote ? e(SectionCard, { title: 'Quote' }, e(JsonBlock, { data: quote })) : null,
			usage ? e(SectionCard, { title: 'Usage Stats' }, e(JsonBlock, { data: usage })) : null
		);
	}

	function ContactView(){
		var _a = useState({ name: '', email: '', message: '' }), form = _a[0], setForm = _a[1];
		var _b = useState({ sending: false, result: null }), status = _b[0], setStatus = _b[1];
		function update(field){ return function(ev){ setForm(Object.assign({}, form, (function(o){ o[field] = ev.target.value; return o; })({}))); }; }
		function submit(ev){ ev.preventDefault(); setStatus({ sending: true, result: null }); ajax('submit_contact_form', form).then(function(resp){ setStatus({ sending: false, result: resp }); }); }
		return e(SectionCard, { title: 'Contact Us' },
			e('form', { onSubmit: submit },
				e('div', { className: 'form-group' }, e('label', { htmlFor: 'c_name' }, 'Name'), e('input', { id: 'c_name', className: 'form-control', value: form.name, onChange: update('name'), required: true })),
				e('div', { className: 'form-group' }, e('label', { htmlFor: 'c_email' }, 'Email'), e('input', { id: 'c_email', type: 'email', className: 'form-control', value: form.email, onChange: update('email'), required: true })),
				e('div', { className: 'form-group' }, e('label', { htmlFor: 'c_message' }, 'Message'), e('textarea', { id: 'c_message', rows: 5, className: 'form-control', value: form.message, onChange: update('message'), required: true })),
				e('button', { className: 'btn', type: 'submit', disabled: status.sending }, status.sending ? 'Sending…' : 'Send Message')
			),
			status.result ? e('div', { style: { marginTop: '0.75rem' } }, e(JsonBlock, { data: status.result })) : null
		);
	}

	function SignupView(){
		var _a = useState({ email: '', password: '' }), form = _a[0], setForm = _a[1];
		var _b = useState({ sending: false, result: null }), status = _b[0], setStatus = _b[1];
		function update(field){ return function(ev){ setForm(Object.assign({}, form, (function(o){ o[field] = ev.target.value; return o; })({}))); }; }
		function submit(ev){ ev.preventDefault(); setStatus({ sending: true, result: null }); ajax('stock_scanner_register_user', form).then(function(resp){ setStatus({ sending: false, result: resp }); }); }
		return e(SectionCard, { title: 'Sign Up' },
			e('form', { onSubmit: submit },
				e('div', { className: 'form-group' }, e('label', { htmlFor: 's_email' }, 'Email'), e('input', { id: 's_email', type: 'email', className: 'form-control', value: form.email, onChange: update('email'), required: true })),
				e('div', { className: 'form-group' }, e('label', { htmlFor: 's_password' }, 'Password'), e('input', { id: 's_password', type: 'password', className: 'form-control', value: form.password, onChange: update('password'), required: true })),
				e('button', { className: 'btn', type: 'submit', disabled: status.sending }, status.sending ? 'Creating…' : 'Create Account')
			),
			status.result ? e('div', { style: { marginTop: '0.75rem' } }, e(JsonBlock, { data: status.result })) : null
		);
	}

	function SettingsView(){
		var _a = useState({ name: '', timezone: '' }), profile = _a[0], setProfile = _a[1];
		var _b = useState({ notifications: false, email_reports: false }), prefs = _b[0], setPrefs = _b[1];
		var _c = useState({ saving: false, saved: null }), status = _c[0], setStatus = _c[1];
		function submitProfile(ev){ ev.preventDefault(); setStatus({ saving: true, saved: null }); ajax('stockscan_update_account', profile).then(function(r){ setStatus({ saving: false, saved: r }); }); }
		function submitPrefs(ev){ ev.preventDefault(); setStatus({ saving: true, saved: null }); ajax('stockscan_update_settings', prefs).then(function(r){ setStatus({ saving: false, saved: r }); }); }
		return e(React.Fragment, null,
			e(SectionCard, { title: 'Profile' },
				e('form', { onSubmit: submitProfile },
					e('div', { className: 'form-group' }, e('label', { htmlFor: 'p_name' }, 'Name'), e('input', { id: 'p_name', className: 'form-control', value: profile.name, onChange: function(ev){ setProfile(Object.assign({}, profile, { name: ev.target.value })); } })),
					e('div', { className: 'form-group' }, e('label', { htmlFor: 'p_tz' }, 'Timezone'), e('input', { id: 'p_tz', className: 'form-control', value: profile.timezone, onChange: function(ev){ setProfile(Object.assign({}, profile, { timezone: ev.target.value })); } })),
					e('button', { className: 'btn', type: 'submit', disabled: status.saving }, status.saving ? 'Saving…' : 'Save Profile')
				)
			),
			e(SectionCard, { title: 'Preferences' },
				e('form', { onSubmit: submitPrefs },
					e('div', { className: 'form-group' },
						e('label', null, e('input', { type: 'checkbox', checked: prefs.notifications, onChange: function(ev){ setPrefs(Object.assign({}, prefs, { notifications: ev.target.checked })); } }), ' Enable notifications')
					),
					e('div', { className: 'form-group' },
						e('label', null, e('input', { type: 'checkbox', checked: prefs.email_reports, onChange: function(ev){ setPrefs(Object.assign({}, prefs, { email_reports: ev.target.checked })); } }), ' Receive email reports')
					),
					e('button', { className: 'btn', type: 'submit', disabled: status.saving }, status.saving ? 'Saving…' : 'Save Preferences')
				)
			),
			status.saved ? e('div', { style: { marginTop: '0.75rem' } }, e(JsonBlock, { data: status.saved })) : null
		);
	}

	function EnhancedWatchlistView(){
		var wl = useAsync([], function(){ return ajax('get_formatted_watchlist_data'); });
		if (wl.loading) return e(Loading);
		if (wl.error) return e(ErrorBox, { message: wl.error });
		return e(SectionCard, { title: 'Enhanced Watchlist' }, e(JsonBlock, { data: wl.data }));
	}

	function PayPalCheckoutView(){
		return e(SectionCard, { title: 'Checkout' }, e('p', null, 'Integrate PayPal buttons here using create-order/capture-order AJAX actions.'));
	}
	function PaymentSuccessView(){ return e(SectionCard, { title: 'Payment Success' }, e('p', null, 'Thank you! Your payment was successful.')); }
	function PaymentCancelledView(){ return e(SectionCard, { title: 'Payment Cancelled' }, e('p', null, 'Your payment was cancelled. You can try again from the pricing page.')); }

	function AccessibilityView(){ return e(SectionCard, { title: 'Accessibility' }, e('p', null, 'We are committed to WCAG compliance and accessibility best practices.')); }
	function SecurityView(){ return e(SectionCard, { title: 'Security' }, e('p', null, 'Report any issues via our contact form.')); }
	function TermsView(){ return e(SectionCard, { title: 'Terms of Service' }, e('p', null, 'Terms content goes here.')); }
	function PrivacyView(){ return e(SectionCard, { title: 'Privacy Policy' }, e('p', null, 'Privacy policy content goes here.')); }
	function CookiePolicyView(){ return e(SectionCard, { title: 'Cookie Policy' }, e('p', null, 'Cookie policy content goes here.')); }

	var routes = [
		{ path: '/', view: HomeView },
		{ path: '/home', view: HomeView },
		{ path: '/dashboard', view: DashboardView },
		{ path: '/market-overview', view: MarketOverviewView },
		{ path: '/watchlist', view: WatchlistView },
		{ path: '/enhanced-watchlist', view: EnhancedWatchlistView },
		{ path: '/portfolio', view: PortfolioView },
		{ path: '/stock-scanner', view: StockScannerView },
		{ path: '/news', view: NewsView },
		{ path: '/contact', view: ContactView },
		{ path: '/signup', view: SignupView },
		{ path: '/user-settings', view: SettingsView },
		{ path: '/paypal-checkout', view: PayPalCheckoutView },
		{ path: '/payment-success', view: PaymentSuccessView },
		{ path: '/payment-cancelled', view: PaymentCancelledView },
		{ path: '/accessibility', view: AccessibilityView },
		{ path: '/security', view: SecurityView },
		{ path: '/terms', view: TermsView },
		{ path: '/privacy', view: PrivacyView },
		{ path: '/cookie-policy', view: CookiePolicyView },
	];

	function matchRoute(path){
		for (var i=0; i<routes.length; i++){
			if (routes[i].path === path) return routes[i];
		}
		return null;
	}

	function App(){
		var _a = useState(window.location.pathname), path = _a[0], setPath = _a[1];
		useEffect(function(){
			function onPop(){ setPath(window.location.pathname); }
			function onClick(ev){
				var anchor = ev.target && ev.target.closest ? ev.target.closest('a[href]') : null;
				if (!anchor) return;
				var href = anchor.getAttribute('href');
				if (!href || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return;
				if (anchor.getAttribute('target') === '_blank') return;
				if (!isInternalHref(href)) return;
				if (href.indexOf('#') === 0) return;
				if (ev.metaKey || ev.ctrlKey || ev.shiftKey || ev.altKey) return;
				ev.preventDefault();
				navigate(href);
			}
			window.addEventListener('popstate', onPop);
			document.addEventListener('click', onClick);
			return function(){ window.removeEventListener('popstate', onPop); document.removeEventListener('click', onClick); };
		}, []);
		var route = matchRoute(path) || { view: function(){ return e(SectionCard, { title: 'Page not found' }, e('p', null, 'The page ' + path + ' was not found.')); } };
		var View = route.view;
		return e(React.Fragment, null,
			e('div', { className: 'app-container' },
				e('div', { className: 'main-content-area' },
					e(Header, null),
					e('main', { className: 'main-content' }, e('div', { className: 'page-content' }, e(View, null)))
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