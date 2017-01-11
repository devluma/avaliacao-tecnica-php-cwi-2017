# avaliacao-tecnica-php-cwi-2017
PROVA TÉCNICA

You should create the following function:
public changeDate(date, op, value);

Where:
-	date: An date as String in the format “d/m/Y H:i”;
-	op: Can be only ‘+’ | ‘-‘;
-	value: the value that should be incremented/decremented. It will be expressed in minutes;

Restrictions:
-	You shall not work with non-native classes / libraries;
-	You shall not make use of none of the following classes DateTime, DateInterval, DatePeriod nor use any of the functions described at http://www.php.net/manual/en/ref.datetime.php
-	If the op is not valid an exception must be thrown;
-	If the value is smaller than zero, you should ignore its signal;
-	Ignore the fact that February have 28/29 days and always consider only 28 days;  
-	Ignore the daylight save time rules.

Example:
- changeDate("01/03/2010 23:00", '+', 4000) = "04/03/2010 17:40"
