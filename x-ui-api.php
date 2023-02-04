<?php
class XUILoL {
    public $Status = 0;
    private $Session = '';
    private $Getaway = 0;   
    public function UUID()  {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0,0xffff ),mt_rand(0,0xffff),
        mt_rand(0,0xffff ),
        mt_rand(0,0x0fff )|0x4000,
        mt_rand(0,0x3fff )|0x8000,
        mt_rand(0,0xffff ),mt_rand(0,0xffff),mt_rand(0,0xffff)
        );
    }
    public function __construct(string $Getaway , string $User , string $Pass) {
        if (!file_exists('Sussec.Ashkan')) :
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://'.$Getaway.'/login');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$Getaway.'','Referer' => 'http://'.$Getaway.'/','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'username='.$User.'&password='.$Pass);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $r = curl_exec($ch);
            if (!json_decode('{'.explode('{',$r)[1])['success']) : $this->Status = 0;else : $this->Status = 1;$this->Session = explode(';',explode('session=',$r)[1])[0];$this->Getaway = $Getaway;file_put_contents('Sussec.Ashkan',base64_encode(urlencode(base64_encode(base64_encode(urlencode(json_encode([$this->Session,$this->Getaway])))))));endif;
            curl_close($ch);
        else : $x = json_decode(urldecode(base64_decode(base64_decode(urldecode(base64_decode(file_get_contents('Sussec.Ashkan')))))));$this->Status = 1;$this->Session = $x[0];$this->$Getaway = $x[1];
        endif;
    }
    public function GetServerStatus() : array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/server/status');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Length' => '0','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
        curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Session);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = json_decode(curl_exec($ch))['obj'];
        curl_close($ch);
        return ['CPU' => round($r['cpu'],2) ,'Hard' => ['Used' => ['MB' => round(($r['disk']['current'] / 1000000) , 2) ,'GB' => round(($r['disk']['current'] / 1000000000) , 2)] ,'All' => ['MB' => round(($r['disk']['total'] / 1000000) , 2) ,'GB' => round(($r['disk']['total'] / 1000000000) , 2)] ,'Available' => ['MB' => round(($r['disk']['total'] / 1000000) , 2) - round(($r['disk']['current'] / 1000000) , 2) ,'GB' => round(($r['disk']['total'] / 1000000000) , 2) - round(($r['disk']['current'] / 1000000000) , 2)]] ,'Load' => $r['loads'] ,'Memory' => ['Used' => ['MB' => round(($r['mem']['current'] / 1000000) , 2) ,'GB' => round(($r['mem']['current'] / 1000000000) , 2)] ,'All' => ['MB' => round(($r['mem']['total'] / 1000000) , 2) ,'GB' => round(($r['mem']['total'] / 1000000000) , 2)] ,'Available' => ['MB' => round(($r['mem']['total'] / 1000000) , 2) - round(($r['mem']['current'] / 1000000) , 2) ,'GB' => round(($r['mem']['total'] / 1000000000) , 2) - round(($r['mem']['current'] / 1000000000) , 2)]] ,'Speed' => ['Upload' => $r['netIO']['up'] / 100 ,'Download' => $r['netIO']['down'] / 100] ,'Traffic' => ['Download' => round($r['netTraffic']['recv'] / 1000000000 , 2) ,'Upload' => round($r['netTraffic']['sent'] / 1000000000 , 2)] ,'XrayStatus' => $r['xray']['running'] ,'Uptime' => ['Day' => round((($r['uptime'] / 60) / 60) / 24 , 1) ,'Hours' => round((($r['uptime'] / 60) / 60) , 2)]];
    }
    public function GetUsersList() : array {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/list');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Length' => '0','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
        curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Session);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = json_decode(curl_exec($ch))['obj'];
        curl_close($ch);
        $Users = [];
        foreach ($r as $User) :
            $Users[] = ['Username' => $User['remark'] , 'Port' => $User['port'] , 'Listen' => $User['listen'] ,'Status' => $User['enable'] ,'Expire' => date('Y-m-d',$User['expiryTime']) ,'ID' => $User['id'] ,'Protocol' => $User['protocol'] ,'Usage' => ['Max' => round($User['total'] / 1000000000 , 2) ,'Downloaded' => round($User['down'] / 1000000000 , 2) ,'Uploaded' => round($User['up'] / 1000000000 , 2)] , 'Settings' => json_decode($User['settings']) , 'Sniffing' => json_decode($User['sniffing']) , 'StreamSettings' => json_decode($User['streamSettings'])];
        endforeach;
        return $Users;
    }
    public function DeleteUser(string $ID) : bool {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/del/'.$ID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Length' => '0','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
        curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Session);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = json_decode(curl_exec($ch))['success'];
        curl_close($ch);
        return (bool) $r;
    }
    public function ResetUsage(string $ID) : bool {
        $Users = $this->GetUsersList();
        $r = '';
        foreach ($Users as $User) :
            if ($User['ID'] == $ID) :
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/update/'.$ID);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
                curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Session);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'up=0&down=0&total='.$User['Usage']['Max'].'&remark='.$User['Username'].'&enable='.$User['Status'].'&expiryTime='.$User['Expire'].'&listen='.$User['Listen'].'&port='.$User['Port'].'&protocol='.$User['Protocol'].'&settings='.urlencode(json_encode($User['Settings'])).'&streamSettings='.urlencode(json_encode($User['StreamSettings'])).'&sniffing='.urlencode(json_encode($User['Sniffing'])));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $r = json_decode(curl_exec($ch))['success'];
                curl_close($ch);
                break;
            endif;
        endforeach;
        return (bool) $r;
    }
    public function ChangeStatus(string $ID): bool {
        $Users = $this->GetUsersList();
        $r = '';
        foreach ($Users as $User) :
            if ($User['ID'] == $ID) :
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/update/'.$ID);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
                curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Session);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'up='.$User['Usage']['Uploaded'].'&down='.$User['Usage']['Downloaded'].'&total='.$User['Usage']['Max'].'&remark='.$User['Username'].'&enable='.($User['Status'] == false ? 'true' : 'false').'&expiryTime='.$User['Expire'].'&listen='.$User['Listen'].'&port='.$User['Port'].'&protocol='.$User['Protocol'].'&settings='.urlencode(json_encode($User['Settings'])).'&streamSettings='.urlencode(json_encode($User['StreamSettings'])).'&sniffing='.urlencode(json_encode($User['Sniffing'])));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $r = json_decode(curl_exec($ch))['success'];
                curl_close($ch);
                break;
            endif;
        endforeach;
        return (bool) $r;
    }
    public function AddUserVmess($Username , $Expire , $Usage = 20 , $Port = rand(20000 , 60000)) : bool {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/add');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
        curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Getaway);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'up=0&down=0&total='.($Usage*1000000000).'&remark='.$Username.'&enable=true&expiryTime='.(time() + (60*60*24*$Expire)).'&listen=&port='.$Port.'&protocol=vmess&settings='.urlencode(json_encode(['clients'=>[['d'=>$this->UUID(),'alterId'=>0]],'disableInsecureEncryption'=>false])).'&streamSettings=%7B%0A%20%20%22network%22%3A%20%22ws%22%2C%0A%20%20%22security%22%3A%20%22none%22%2C%0A%20%20%22wsSettings%22%3A%20%7B%0A%20%20%20%20%22path%22%3A%20%22%2F%22%2C%0A%20%20%20%20%22headers%22%3A%20%7B%7D%0A%20%20%7D%0A%7D&sniffing=%7B%0A%20%20%22enabled%22%3A%20true%2C%0A%20%20%22destOverride%22%3A%20%5B%0A%20%20%20%20%22http%22%2C%0A%20%20%20%20%22tls%22%0A%20%20%5D%0A%7D');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return json_decode($r)['success'];
    }
    public function AddUserVless($Username , $Expire , $Usage = 20 , $Port = rand(20000 , 60000)) : bool {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->Getaway.'/xui/inbound/add');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json, text/plain, */*','Accept-Language' => 'en-US,en;q=0.9,fa;q=0.8','Connection' => 'keep-alive','Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8','Origin' => 'http://'.$this->Getaway.'','Referer' => 'http://'.$this->Getaway.'/xui/inbounds','User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36','X-Requested-With' => 'XMLHttpRequest','Accept-Encoding' => 'gzip',]);
        curl_setopt($ch, CURLOPT_COOKIE, 'session='.$this->Getaway);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'up=0&down=0&total='.($Usage*1000000000).'&remark='.$Username.'&enable=true&expiryTime='.(time() + (60*60*24*$Expire)).'&listen=&port='.$Port.'&protocol=vless&settings='.urlencode(json_encode(['clients'=>[['id'=>$this->UUID(),'flow'=>'xtls-rprx-direct']],'decryption'=>'none','fallbacks'=>[]])).'&streamSettings=%7B%0A%20%20%22network%22%3A%20%22ws%22%2C%0A%20%20%22security%22%3A%20%22none%22%2C%0A%20%20%22wsSettings%22%3A%20%7B%0A%20%20%20%20%22path%22%3A%20%22%2F%22%2C%0A%20%20%20%20%22headers%22%3A%20%7B%7D%0A%20%20%7D%0A%7D&sniffing=%7B%0A%20%20%22enabled%22%3A%20true%2C%0A%20%20%22destOverride%22%3A%20%5B%0A%20%20%20%20%22http%22%2C%0A%20%20%20%20%22tls%22%0A%20%20%5D%0A%7D');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return json_decode($r)['success'];
    }
}
?>