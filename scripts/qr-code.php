<?php
class QR_BarCode{
    // Google Chart API URL
    private $googleChartAPI = 'http://chart.apis.google.com/chart';    // Code data
    private $codeData;    /**
     * URL QR code
     * @param string $url
     */
    public function url($url = null){
        $this->codeData = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
    }    /**
     * Text QR code
     * @param string $text
     */
    public function text($text){
        $this->codeData = $text;
    }    /**
	 * Email address QR code
	 *
	 * @param string $email
	 * @param string $subject
	 * @param string $message
	 */
	public function email($email = null, $subject = null, $message = null) {
		$this->codeData = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}    /**
     * Phone QR code
     * @param string $phone
     */
    public function phone($phone){
        $this->codeData = "TEL:{$phone}";
    }    /**
	 * SMS QR code
	 *
	 * @param string $phone
	 * @param string $text
	 */
	public function sms($phone = null, $msg = null) {
		$this->codeData = "SMSTO:{$phone}:{$msg}";
	}    /**
	 * VCARD QR code
	 *
	 * @param string $name
	 * @param string $address
	 * @param string $phone
	 * @param string $email
	 */
	public function contact($name = null, $address = null, $phone = null, $email = null) {
		$this->codeData = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
	}    /**
	 * Content (gif, jpg, png, etc.) QR code
	 *
	 * @param string $type
	 * @param string $size
	 * @param string $content
	 */
	public function content($type = null, $size = null, $content = null) {
		$this->codeData = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}    /**
	 * Generate QR code image
	 *
	 * @param int $size
	 * @param string $filename
	 * @return bool
	 */
	public function qrCode($size = 400, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->googleChartAPI);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->codeData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}		return false;
	}}
?><?php
$qr = new QR_BarCode();

if(isset($_GET['type'])){
  switch($_GET['type']){
      case 'url':
      if (isset($_GET['url'])) {
        $qr->url($_GET['url']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'url',
            'sample_values'=> ['https://www.biswabijaya.com','http://wbweb.co.in']
        ));
        $arr = array(
            'error'=>'Void url API - Param Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      case 'whatsapp':
      if (isset($_GET['phone'])) {
        $url = 'https://wa.me/'.$_GET['phone'];
        $qr->url($url);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'phone',
            'sample_values'=> ['919090374605'],
            'limitation' => 'Country code with number without + symbol required'
        ));
        $arr = array(
            'error'=>'Void whatsapp API - Param Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      case 'text':
      if (isset($_GET['text'])) {
        $qr->text($_GET['text']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'text',
            'sample_values'=> ['ABRA123KA789DABRA','90903','BISWA']
        ));
        $arr = array(
            'error'=>'Void text API - Param Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      case 'phone':
      if (isset($_GET['phone'])) {
        $qr->phone($_GET['phone']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'phone',
            'sample_values'=> ['9090374605','+919090374605','919090374605']
        ));
        $arr = array(
            'error'=>'Void phone API - Param Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      case 'sms':
      if (isset($_GET['phone']) and isset($_GET['msg'])) {
        $qr->sms($_GET['phone'],$_GET['msg']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'phone',
            'sample_values'=> ['9090374605','+919090374605','919090374605']
        ));
        array_push($param,array(
            'param_name'=>'msg',
            'sample_values'=> ['This is sample message.','H! buddy','How are you?'],
            'limitatations'=> 'single quote to be avoided'
        ));
        $arr = array(
            'error'=>'Void SMS API - Params Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      case 'email':
      if (isset($_GET['email']) and isset($_GET['subject']) and isset($_GET['msg'])) {
        $qr->email($_GET['email'],$_GET['subject'],$_GET['msg']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'email',
            'sample_values'=> ['me@biswabijaya.com','biswabijayasamal@gmail.com']
        ));
        array_push($param,array(
            'param_name'=>'subject',
            'sample_values'=> ['This is sample subject.'],
            'limitatations'=> 'single quote to be avoided'
        ));
        array_push($param,array(
            'param_name'=>'msg',
            'sample_values'=> ['This is sample message.','H! buddy','How are you?'],
            'limitatations'=> 'single quote to be avoided'
        ));
        $arr = array(
            'error'=>'Void Email API - Params Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      case 'contact':
      if (isset($_GET['name']) and isset($_GET['address']) and isset($_GET['phone']) and isset($_GET['email'])) {
        $qr->contact($_GET['name'],$_GET['address'],$_GET['phone'],$_GET['email']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'name',
            'sample_values'=> ['FirstName LastName','FirstName','FirstName MiddleName LastName']
        ));
        array_push($param,array(
            'param_name'=>'email',
            'sample_values'=> ['me@biswabijaya.com','biswabijayasamal@gmail.com']
        ));
        array_push($param,array(
            'param_name'=>'phone',
            'sample_values'=> ['9090374605','+919090374605','919090374605']
        ));
        array_push($param,array(
            'param_name'=>'address',
            'sample_values'=> ['New Delhi, India'],
            'limitatations'=> 'single quote to be avoided'
        ));
        $arr = array(
            'error'=>'Void Contact API - Params Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      case 'content':
      if (isset($_GET['kind']) and isset($_GET['size']) and isset($_GET['content'])) {
        $qr->content($_GET['kind'],$_GET['size'],$_GET['content']);
        $qr->qrCode();
      } else {
        $param = [];
        array_push($param,array(
            'param_name'=>'kind',
            'sample_values'=> ['gif','jpg','png','pdf','doc','etc.']
        ));
        array_push($param,array(
            'param_name'=>'size',
            'sample_values'=> ['13 kb','1 mb','1000 byte'],
            'limitatations'=> 'specify size with type'
        ));
        array_push($param,array(
            'param_name'=>'content',
            'sample_values'=> 'encoded data'
        ));
        $arr = array(
            'error'=>'Void Content API - Params Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      }
      break;
      break;
      default:
        $param = [];
        array_push($param,array(
            'param_name'=>'type',
            'possible_values'=> ['url','text','email','phone','sms','vcarcontactd','content']
        ));
        $arr = array(
            'error'=>'Void API - Param Required',
            'params_required'=> $param
        );
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
      break;
  }
} else {
    $param = [];
    array_push($param,array(
        'param_name'=>'type',
        'possible_values'=> ['url','text','email','phone','sms','contact','content']
    ));
    $arr = array(
        'error'=>'Void API - Param Required',
        'params_required'=> $param
    );
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"><pre>'.json_encode($arr,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</pre>';
}
?>
<?php
// QRcode object// create text QR code
