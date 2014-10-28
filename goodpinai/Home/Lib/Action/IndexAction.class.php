<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	//显示首的页方法
    public function index(){
		$this->display();
	}

	//登录或注册的方法，因为登录注册在一个页面
	public function login_reg(){
		$this->display();
	}

	//登录的方法
	public function do_login(){
		$where_data['email'] = $_POST['email'];
		$where_data['upwd'] = hcy_md6($_POST['pwd']);
		$users = M('Users');
		$res = $users->where($where_data)->find();

		if($res){
			// 登录成功，存session
			session('id', $res['id']); // 用户id
			session('jlcoin', $res['jlcoin']); // 精灵币

			// 登录成功后修改上次登录时间为当前时间
			$upd_data['pretime'] = time();
			$id = $users->where($where_data)->save($upd_data);
			if($id){
				$this->success('登录成功',U('List/index'));
			}else{
				$this->error('失败');
			}
			
		}else{
			$this->error('用户名或密码错误');
		}
	}

	//注册的方法
	public function do_reg(){
		$agreed = $_POST['agreed'];
		if($agreed){ // 同意条框
			// 接收注册数据
			$reg_data['nickname'] = $_POST['nickname'];
			$reg_data['email'] = $_POST['email'];

			$email_pattern = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/'; // 匹配邮箱地址的正则
			preg_match($email_pattern, $_POST['email'], $match);
			if(!$match){
				$this->error('你输入的邮箱地址不正确');
			}

			$reg_data['upwd'] = hcy_md6($_POST['pwd']);

			$repwd = $_POST['repwd'];
			
			if($repwd == $_POST['pwd']){ // 密码与确认密码相同

				// 密码验证规则 /^[_0-9a-z]{6,16}$/
				$pattern = '/^[_0-9a-z]{6,16}$/';
				preg_match($pattern, $_POST['pwd'], $match2);
				if($match2){
					$users = M('Users');
					
					//检测邮箱是否已存在
					$meail_exists['email'] = $reg_data['email'];
					$res = $users->where($meail_exists)->find();
					if(!$res){
						$id = $users->add($reg_data);
						
						if($id){
							// 发送邮件
							require_once './Public/email.ini'; // 引入邮件配置信息
							$this->smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
							$this->debug = false;//是否显示发送的调试信息
							$state = $this->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

							// 邮件发送失败
							if($state == ""){
								$this->error('邮件发送失败');
							}
								
							// 激活账号验证用
							session('email_uid',hcy_md6($id));
							
							// 如果程序运行到这里说明邮件发送成功
							$this->success('注册成功，请查收邮件并激活账号');
						}else{
							$this->error('注册失败');
						}
					}else{
						$this->error('邮箱已存在');
					}
				}else{
					$this->error('您输入的密码不符合规则');
				}
			}else{ // 密码与确认密码不同
				$this->error('密码与确认密码不同');
			}
			
		}else{
			$this->error('请勾选同意使用条框');
		}
	}

	
	// 激活账号的方法
	public function activation(){
		if(hcy_md6($_GET['bzDss']) == session('email_uid')){
			$users = M('Users');
			
			//更新状态
			$upd_data['status'] = 1;
			//条件
			$where_data['id'] = $_GET['bzDss'];

			$id = $users->where($where_data)->save($upd_data);
			if($id){
				$this->success('账号激活成功',U('Index/login_reg'));
			}else{
				$this->error('激活失败');
			}
		}else{
			$this->error('非法访问');
		}
	}

	//下面邮件发送定义的一些属性和方法************************************************************************************

	/* Public Variables */

	public $smtp_port;

	public $time_out;

	public $host_name;

	public $log_file;

	public $relay_host;

	public $debug;

	public $auth;

	public $user;

	public $pass;

	/* Private Variables */ 
	public $sock;

	/* Constractor */

	public function smtp($relay_host = "", $smtp_port = 25,$auth = false,$user,$pass)

	{

	$this->debug = FALSE;

	$this->smtp_port = $smtp_port;

	$this->relay_host = $relay_host;

	$this->time_out = 30; //is used in fsockopen() 
	#

	$this->auth = $auth;//auth

	$this->user = $user;

	$this->pass = $pass;

	#

	$this->host_name = "localhost"; //is used in HELO command 
	$this->log_file = "";

	$this->sock = FALSE;

	}

	/* Main Function */

	public function sendmail($to, $from, $subject = "", $body = "", $mailtype, $cc = "", $bcc = "", $additional_headers = "")

	{

	$mail_from = $this->get_address($this->strip_comment($from));

	$body = @ereg_replace("(^|(\r\n))(\.)", "\1.\3", $body);

	$header = "MIME-Version:1.0\r\n";

	if($mailtype=="HTML"){

	$header .= "Content-Type:text/html\r\n";

	}

	$header .= "To: ".$to."\r\n";

	if ($cc != "") {

	$header .= "Cc: ".$cc."\r\n";

	}

	$header .= "From: $from<".$from.">\r\n";

	$header .= "Subject: ".$subject."\r\n";

	$header .= $additional_headers;

	$header .= "Date: ".date("r")."\r\n";

	$header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";

	list($msec, $sec) = explode(" ", microtime());

	$header .= "Message-ID: <".date("YmdHis", $sec).".".($msec*1000000).".".$mail_from.">\r\n";

	$TO = explode(",", $this->strip_comment($to));

	if ($cc != "") {

	$TO = array_merge($TO, explode(",", $this->strip_comment($cc)));

	}

	if ($bcc != "") {

	$TO = array_merge($TO, explode(",", $this->strip_comment($bcc)));

	}

	$sent = TRUE;

	foreach ($TO as $rcpt_to) {

	$rcpt_to = $this->get_address($rcpt_to);

	if (!$this->smtp_sockopen($rcpt_to)) {

	$this->log_write("Error: Cannot send email to ".$rcpt_to."\n");

	$sent = FALSE;

	continue;

	}

	if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body)) {

	$this->log_write("E-mail has been sent to <".$rcpt_to.">\n");

	} else {

	$this->log_write("Error: Cannot send email to <".$rcpt_to.">\n");

	$sent = FALSE;

	}

	fclose($this->sock);

	$this->log_write("Disconnected from remote host\n");

	}

	return $sent;

	}

	/* Private Functions */

	public function smtp_send($helo, $from, $to, $header, $body = "")

	{

	if (!$this->smtp_putcmd("HELO", $helo)) {

	return $this->smtp_error("sending HELO command");

	}

	#auth

	if($this->auth){

	if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {

	return $this->smtp_error("sending HELO command");

	}

	if (!$this->smtp_putcmd("", base64_encode($this->pass))) {

	return $this->smtp_error("sending HELO command");

	}

	}

	#

	if (!$this->smtp_putcmd("MAIL", "FROM:<".$from.">")) {

	return $this->smtp_error("sending MAIL FROM command");

	}

	if (!$this->smtp_putcmd("RCPT", "TO:<".$to.">")) {

	return $this->smtp_error("sending RCPT TO command");

	}

	if (!$this->smtp_putcmd("DATA")) {

	return $this->smtp_error("sending DATA command");

	}

	if (!$this->smtp_message($header, $body)) {

	return $this->smtp_error("sending message");

	}

	if (!$this->smtp_eom()) {

	return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");

	}

	if (!$this->smtp_putcmd("QUIT")) {

	return $this->smtp_error("sending QUIT command");

	}

	return TRUE;

	}

	public function smtp_sockopen($address)

	{

	if ($this->relay_host == "") {

	return $this->smtp_sockopen_mx($address);

	} else {

	return $this->smtp_sockopen_relay();

	}

	}

	public function smtp_sockopen_relay()

	{

	$this->log_write("Trying to ".$this->relay_host.":".$this->smtp_port."\n");

	$this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);

	if (!($this->sock && $this->smtp_ok())) {

	$this->log_write("Error: Cannot connenct to relay host ".$this->relay_host."\n");

	$this->log_write("Error: ".$errstr." (".$errno.")\n");

	return FALSE;

	}

	$this->log_write("Connected to relay host ".$this->relay_host."\n");

	return TRUE;;

	}

	public function smtp_sockopen_mx($address)

	{

	$domain = ereg_replace("^.+@([^@]+)$", "\1", $address);

	if (!@getmxrr($domain, $MXHOSTS)) {

	$this->log_write("Error: Cannot resolve MX \"".$domain."\"\n");

	return FALSE;

	}
	//专注与php学习 http://www.daixiaorui.com 欢迎您的访问

	foreach ($MXHOSTS as $host) {

	$this->log_write("Trying to ".$host.":".$this->smtp_port."\n");

	$this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);

	if (!($this->sock && $this->smtp_ok())) {

	$this->log_write("Warning: Cannot connect to mx host ".$host."\n");

	$this->log_write("Error: ".$errstr." (".$errno.")\n");

	continue;

	}

	$this->log_write("Connected to mx host ".$host."\n");

	return TRUE;

	}

	$this->log_write("Error: Cannot connect to any mx hosts (".implode(", ", $MXHOSTS).")\n");

	return FALSE;

	}

	public function smtp_message($header, $body)

	{

	fputs($this->sock, $header."\r\n".$body);

	$this->smtp_debug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));

	return TRUE;

	}

	public function smtp_eom()

	{

	fputs($this->sock, "\r\n.\r\n");

	$this->smtp_debug(". [EOM]\n");

	return $this->smtp_ok();

	}

	public function smtp_ok()

	{

	$response = str_replace("\r\n", "", fgets($this->sock, 512));

	$this->smtp_debug($response."\n");

	if (!@ereg("^[23]", $response)) {

	fputs($this->sock, "QUIT\r\n");

	fgets($this->sock, 512);

	$this->log_write("Error: Remote host returned \"".$response."\"\n");

	return FALSE;

	}

	return TRUE;

	}

	public function smtp_putcmd($cmd, $arg = "")

	{

	if ($arg != "") {

	if($cmd=="") $cmd = $arg;

	else $cmd = $cmd." ".$arg;

	}

	fputs($this->sock, $cmd."\r\n");

	$this->smtp_debug("> ".$cmd."\n");

	return $this->smtp_ok();

	}

	public function smtp_error($string)

	{

	$this->log_write("Error: Error occurred while ".$string.".\n");

	return FALSE;

	}

	public function log_write($message)

	{

	$this->smtp_debug($message);

	if ($this->log_file == "") {

	return TRUE;

	}

	$message = date("M d H:i:s ").get_current_user()."[".getmypid()."]: ".$message;

	if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {

	$this->smtp_debug("Warning: Cannot open log file \"".$this->log_file."\"\n");

	return FALSE;;

	}

	flock($fp, LOCK_EX);

	fputs($fp, $message);

	fclose($fp);


	return TRUE;

	}


	public function strip_comment($address)

	{

	$comment = "\([^()]*\)";

	while (@ereg($comment, $address)) {

	$address = ereg_replace($comment, "", $address);

	}


	return $address;

	}


	public function get_address($address)

	{

	$address = @ereg_replace("([ \t\r\n])+", "", $address);

	$address = @ereg_replace("^.*<(.+)>.*$", "\1", $address);

	return $address;

	}

	public function smtp_debug($message)

	{

	if ($this->debug) {

	echo $message;

	}

	}
}