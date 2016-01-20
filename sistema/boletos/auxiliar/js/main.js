
$(document).ready(function(){
      $(function()
      {
    	  $('.date-pick').datePicker({startDate:'01/01/2009'});
      });
        
      $(".cancelar").live('click',function(){
    	  history.back(1);
      });
      
      $(".sortable").sortable();

      $(".maiusculas").live('keyup',function(){
          toUpper(this);
      });

      $(".strLower").keyup(function(){
          toLower(this);
      });

      $(".numeral").live('keyup',function(){
          numeroMasc(this);
      });

      $(".valor").live('keyup',function(){
          valorMasc(this);
      });
	
});



