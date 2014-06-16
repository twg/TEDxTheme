<input type="text" name="_partner_url" id="partner_url" style="width: 95%;" value="<?= $partner_url; ?>"/>
<input type="hidden" name="_partner_url_nonce" value="<?= wp_create_nonce('tedx_partner_url_nonce'); ?>"/>
<p class="description">The full url to the partners website (eg. <strong>http://www.cnn.com</strong>)</p>