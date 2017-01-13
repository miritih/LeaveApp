function CalValidate(date){
      var condition
	var max_agents = $('#max_agents').val();
        var g;
              if(month<=3 && month>=1){
                 //condition =  date.getMonth()+1<1 || date.getMonth()+1>3;
				 condition =  date.getMonth()+1>3
             }else if(month<=6 && month>=4){
               condition =  date.getMonth()+1<4 || date.getMonth()+1>6;
              }else if(month<=9 && month>=7){
                condition =  date.getMonth()+1<7 || date.getMonth()+1>9;
              }else if(month<=12 && month>=10){
                //condition =  date.getMonth()+1<10 || date.getMonth()+1>12;
                condition =  date.getMonth()+1>3
             }
		
            /*console.log(fullyBooked(date));  if (date.getDay()== 6||date.getDay()== 0||date.getFullYear()!=now.getFullYear()||date < now || condition||fullyBooked(date)>=2){*/
            if (date.getDay()==6||date.getDay()== 0||/*date.getFullYear()!=now.getFullYear()||*/date < now ||fullyBooked(date)>=max_agents || condition){
                return false;
            } else {
                return true;
            }
    }
	

	/*check if a day is fully booked*/
    function fullyBooked(date){
       var dat='';
        var yy = date.getFullYear();
                  var mon = date.getMonth()+1;
                  var day = date.getDate();
                  var dateZ= yy+'-'+(mon<10?('0'+mon):mon)+'-'+(day<10?('0'+day):day);
        $.ajax({
                async: false,
                type: "GET",
                url: "date",
				dataType: 'json',
                data: {date : dateZ },
                dataType: "json",
                success : function(data) {
                        dat=data;
                          }
              });
        return dat;
    }