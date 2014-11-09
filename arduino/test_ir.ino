
unsigned long time = 0;
unsigned long time1 = 0;
unsigned long time2 = 0;
unsigned long count = 0;
unsigned long count_prev = count ;
int first  =0;

void setup()
{
    Serial.begin(9600);
     pinMode(A0,INPUT);
}


void loop()
{
    int ir_;
    ir_ = analogRead(A0);
    
    if (ir_ > 500)
    {
      if ( first == 0)
      {
        time = millis();
        first = 1;
        count = 1 ;
      }
      else
      {
        time1 =millis() ;
        time2 = time1 - time;
        if (time2 > 500)
          count++;
        time = time1;
      }
      if (count_prev != count)
        Serial.println(count);
      count_prev = count;
    }
   // delay(80) ;
    
    
}
