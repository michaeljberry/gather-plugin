$(document).ready(function () {
	let baseUrl = window.location.origin;
	let h1 = $( "h1:contains('Official Announcements & Alerts')" );
	let h2 = $( "h2:contains('Official Announcements & Alerts')" );

	let certContent  = '';

	certContent += '<div style="display: flex; margin: 15px 20px;">';
		certContent += '<div style="display: flex; align-items: center; margin-right: 15px;">Our Emergency Alert Texting System is certified by:</div>';
		certContent += `<a href="${baseUrl}/wp-content/plugins/gather/assets/Twilio-ISO-27001-27017-27018-Certificate-Award-6.22.2022-1.pdf" target="_blank" rel="noopener">`;
			certContent += `<img src="${baseUrl}/wp-content/plugins/gather/assets/images/coalfire.png" style="width: 175px; height: auto; border: 1px solid #ccc;" />`;
		certContent += '</a>';
	certContent += '</div>';

	$( certContent ).insertAfter( h1 );

	$( certContent ).insertAfter( h2 );
});

(function () {
	Array.from(document.querySelectorAll('.wp-block-frm-modal-button__link')).map(button => {
		button.onclick = () => {
			const url = new URL(window.location.href);
			url.searchParams.set('form', button.dataset.target);
			window.history.replaceState(null, null, url)
		};
	});
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const form = urlParams.get('form');
	if (form) {
		setTimeout(function() {
			Array.from(document.querySelectorAll('.wp-block-frm-modal-button__link')).filter(button => button.dataset.target == `${form}`)[0].click();
		}, 500);
	}
})();