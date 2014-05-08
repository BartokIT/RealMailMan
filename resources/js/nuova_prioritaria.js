

 $(function(){
       
       
       var sTableRow='<tr><td class="quantity"><input class="quantity-input" type="text" name="pieghi[]" value=""/></td>'+				
				'<td class="prot"><input class="prot-input" type="text" name="prot[]" value=""/></td>' +
				'<td class="type"><input class="type-input" type="text" name="categoria[]" value="" /></td>'+
				'<td class="delete"><a href="#"><img src="resources/css/del_row.png" alt="Cancella riga"/></a></td>'+
			'</tr>';
       var addRow = function(protocol,quantity,item_type)
       {

              var oNewRow = $(sTableRow);
              
              protocol = protocol || '';
              quantity = quantity || '';
              item_type = item_type || '';
              $("#prioritaria_table tbody").append(oNewRow);
              
              $(oNewRow).find(".type input.type-input").val(item_type).autocomplete({
                     source: ["Lettere", "Inviti","Stampati"],
                     autoFocus: true,
                     change: function( event, ui ) {
                           //TODO
                     }
              });
              
              $(oNewRow).find(".quantity input").mask ("?999999").val(quantity);
              $(oNewRow).find(".prot input").val(protocol).tokenfield({ delimiter: [' ',".",';',','] });

              return oNewRow;
       };
       
       var saveForm=function()
       {
              $.cookie("prioritaria_data",$("#rows_form").serialize());
       }
       
       var validateForm = function()
       {
              var berrors=true;
              $("#prioritaria_table tbody tr .quantity input").each(function(i,el){
                     if ($(el).val() == "") {
                            berrors=false;
                            $(el).addClass("wrong");
                     }
              });
              $("#prioritaria_table tbody tr .type input").each(function(i,el){
                     if ($(el).val() == "") {
                            berrors=false;
                            $(el).addClass("wrong");
                     }
              });
              return berrors;
       };
       
       $(document).on("keypress","#prioritaria_table tbody tr input",function(e) {
              $(this).removeClass("wrong");
              
       });
       
       
       //Initial loading management
       if ($.cookie("prioritaria_data")) {
             var sData = $.deparam($.cookie("prioritaria_data"));
             if (sData.nonce == $("#rows_form  input[name=nonce]").val()) {
                    var iLen = sData.pieghi.length;
                    for (var i=0; i < iLen; i++)
                    {
                            var oRow;
                            oRow = addRow(sData.prot[i],sData.pieghi[i],sData.categoria[i]);
                    }
             }
             else
                     addRow();
             
       }
       else
       {
              oRow = addRow();
       }
       
       var sStatus="i";
       
       //Add a row to the table
       $("#add_row").click(function()
       {
              addRow()
       });
	
       //Handler of the submit button
       $("#rows_form").submit(function(e)
       {
              if (sStatus == "i")
              {
                           e.preventDefault();
                           if (validateForm())
                           {
                                  $("#prioritaria_table tbody tr input").each(function (index,element){
                                          $(element).css("border", "1px solid transparent");
                                          $(element).attr("readonly", "readonly");	
                                  });
                                  $("#confirm_rows").attr('value','Conferma');
                  
                                  sStatus="s";
                                  $("#add_row").hide();
                                  $("#deconfirm_rows").show();
                                  $("#back").hide();
                                  $(".delete a").hide();
                           }
                           
              }
       
       });
        
       //Handler of the "deconfirm/back" button
       $("#deconfirm_rows").click(function()
       {
           
           if (sStatus == "s")
           {
              sStatus="i";
              $("#prioritaria_table tbody tr input").each(function (index,element){
                      $(element).css("border", "1px solid rgb(200, 200, 200)");			
                      $(element).removeAttr("readonly");
              });
              $("#confirm_rows").attr('value','Inserisci');			
              $("#add_row").show();			
              $("#deconfirm_rows").show();
              $("#deconfirm_rows").hide();
              $("#back").show();
              $(".delete a").show();
              
           }
           else if (sStatus == "i")
           {
                        
           }
       });
        
       $("#rows_form #prioritaria_table").on("change",function(e){
              $.cookie("prioritaria_data",$("#rows_form").serialize());
              console.log("*");
       });
       $("#rows_form .type input.type-input").on("autocompleteselect",function(e){
              //$.cookie("prioritaria_data",$("#rows_form").serialize());
              console.log("-");
       });


       
       //Handler of the delete a row
       $(document).on("click",".delete a",function(e)
	    {
		    if ($("#prioritaria_table tbody tr").length > 1)
		    {		       		    
	            var row = $(e.target).closest("tr");
	            var tbody = row.parent();
	            var counter = row.find(".counter").text();
	            $(row).remove();
		    }
		    else
		    {
              $("<p>E' necessario  sia presente almeno una riga</p>").dialog(
              {
                     modal: true,
                     title: "Impossibile cancellare la riga",
                     buttons: {
                             OK: function() {
                         $( this ).dialog( "close" );
                         }
                       }
              });
		    }
	    });
       //setup before functions
       var typingTimer;                //timer identifier
       var doneTypingInterval = 5000;  //time in ms, 5 second for example
       
       //on keyup, start the countdown
       $('#myInput').keyup(function(){
           typingTimer = setTimeout(doneTyping, doneTypingInterval);
       });
       
       //on keydown, clear the countdown 
       $('#myInput').keydown(function(){
           clearTimeout(typingTimer);
       });
       
       //user is "finished typing," do something
       function doneTyping () {
           //do something
       }
   
});
