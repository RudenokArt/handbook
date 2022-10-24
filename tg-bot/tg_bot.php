<?php 

/**
 * 
 */
class Tg_bot {

  function __construct($php_input_json)  {
    $this->url = 'https://api.telegram.org/bot5779405986:AAExrHLhMBmA-HLstR1DbUdcQO05TCL65uo/';
    $this->greeteng = 'Чем могу вам помочь?';
    $this->php_input_json = $php_input_json;
    $this->php_input_arr = json_decode($php_input_json, true);
    $this->user_id = $this->php_input_arr['message']['from']['id'];
  }

  function sendButtons () {
    $keyboard = [
      'inline_keyboard' => [
        [['text' =>  'Я хочу зарегистрироваться', 'callback_data' =>'registration']],
        [['text' =>  'Я забыл свой пароль (логин)', 'callback_data' =>'password_recovery']],
      ],
    ];
    $message_text = 'Чем могу вам помочь?';
    $reply = json_encode($keyboard);
    file_get_contents($this->url."/sendMessage?chat_id=".$this->user_id."&text=".$this->greeteng." : &reply_markup=".$reply );
  }

  function sendBootMessage ($message_text='') {
    if (!$message_text) {
      $message_text = $this->greeteng;
    }
    file_get_contents($this->url.'sendMessage?chat_id='.$this->user_id.'&text='.$message_text);
  }
}

?>