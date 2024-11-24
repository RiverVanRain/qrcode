import 'jquery';
import Ajax from 'elgg/Ajax';
import i18n from 'elgg/i18n';
import lightbox from 'elgg/lightbox';
	
const ajax = new Ajax();

ajax.action($('.qrcode-container').attr('action')).done(function (response) {
	$('.qrcode-content').append($('<div><img src='+ response.url +'></div><div><a class="elgg-button elgg-button-action" href='+ response.url +'>'+ i18n.echo('qrcode:download') +'</a></div>'));
}).fail(function () {
	lightbox.close();
});
