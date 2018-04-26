<?php 

if (isset($_POST['firstname'])) {
				$values['firstname']    = trim(stripslashes($_POST['firstname']));
				if ( ( $this->is_mandatory_field( 'name' ) && empty( $values['firstname'] ) ) ||
					 preg_match('/[\n\r]/', $values['firstname']) ) {
					$errors['firstname']  = true;
				}
			}


$body .= $values['firstname'] . ' ' . $values['name'] . "\n";
						if (isset($values['street'])) {
							$body .= $values['street'] . ' ' . $values['streetnumber'] . "\n";


/* Create XML Document */
$xmlDoc = new DOMDocument('1.0');
$xmlDoc->formatOutput = true;
$xmlDoc->encoding = "iso-8859-1";
 
/* Build Maximizer XML file */
$xmlRoot = $xmlDoc->createElement('openimmo_feedback');


$xmlDoc->appendChild($xmlRoot);
$xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsd', 'https://www.w3.org/2001/XMLSchema');
$xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsi', 'https://www.w3.org/2001/XMLSchema-instance');

$xmlversion = $xmlDoc->createElement('version', '1.2.5');
 $xmlRoot->appendChild($xmlversion);

$xmlsender = $xmlDoc->createElement('sender');
 $xmlRoot->appendChild($xmlsender);


$xmlName = $xmlDoc->createElement('name', 'Immowelt');
$xmlsender->appendChild($xmlName );


$content = chunk_split(base64_encode($xmlDoc->saveXML()));

$dir = plugin_dir_path( __FILE__ );
$filename = $dir . "upload/" . $values['firstname'] . "-" . date('Y-m-d') . ".xml";

$xmlDoc->save($filename);
$attachments = array($filename);

if ( $to == 'none' || !wp_mail( $to, $subject, $body, $headers, $attachments ) ) {
							$mail_errors[] = $to;
						}
