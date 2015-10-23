#include <Servo.h>
#include <Bridge.h>
#include <HttpClient.h>

Servo myservo;
HttpClient client;
int num = 0;
int should = 0;
volatile bool out_flag = false;
volatile int in_flag = 0;
volatile int output = 0;
long i = 0;
int pos = 0;
String str = "";

void setup() {
  myservo.attach(4);
  attachInterrupt(0, coin_in, FALLING);
  attachInterrupt(1, coin_out, FALLING);
  Bridge.begin();
  Console.begin(); 
  //while (!Console); 
}

void loop() {
  
  if (i%500000 == 0) {
    /*
    // いままで入れた金額を取得する
    String url = "http://kawashimadaichi.tokyo/coin/get_real_coin.php";
    client.get(url);
    str = "";
    while (client.available()) {
      str += (char)client.read();
    }
    num = str.toInt();
    Console.print("now in : ");
    Console.println(num);
    // 電気料金を取得する
    url = "http://kawashimadaichi.tokyo/coin/get_charge.php";
    client.get(url);
    str = "";
    while (client.available()) {
      str += (char)client.read();
    }
    charge = str.toInt();
    Console.print("charge : ");
    Console.println(charge);
    if (should < 0) output = num;
    else output = num - should;
    //if (output < 0) output = num;
    Console.print("should out : ");
    Console.println(output);
    */
    // 何枚出すかを取得する
    String url = "http://pikashi.tokyo:8080/output";
    client.get(url);
    str = "";
    while (client.available()) {
      str += (char)client.read();
    }
    output = str.toInt();
    Console.print("output : ");
    Console.println(output);
  }
  
  /*
  // 入ってるコインの数を減らす
  if (output > 0) {
    String url = "http://kawashimadaichi.tokyo/coin/coin_out.php?reduce=";
    String strnum = String(output);
    url.concat(strnum);
    client.get(url);
  }
  */
  
  // 出すコインがあればサーボを回す
  while (output > 0) {
    for (; pos <= 180; pos += 1) {         
      if (output == 0) {
        break;
      }
      myservo.write(pos);
      delay(30);
    } 
    for (; pos>=0; pos-=1) {         
      if (output == 0) {
        break;
      }    
      myservo.write(pos);
      delay(30);
    }
  }
  
  // コインが入った時の処理
  if (in_flag > 0) {
    Console.println("coin in");
    String url = "http://pikashi.tokyo:8080/input/100";
    client.get(url);
    str = "";
    while (client.available()) {
      str += (char)client.read();
    }
    Console.print("now in : ");
    num = str.toInt();
    Console.println(num);
    in_flag--;
  }
    
  i++;
}

void coin_in(){
  in_flag++;
}

void coin_out(){
  if (output > 0) {
    output--;
  }
}
