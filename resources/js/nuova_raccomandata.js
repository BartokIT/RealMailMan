$(function(){
       var sStatus="i";
       var sTableRow='<tr>'+
                   '<td class="counter">1</td>'+
                   '<td class="protocol"><input class="protocol-input" type="text" name="prot[]" value=""/></td>'+
                   '<td class="receiver"><input class="receiver-input" type="text" name="destinatario[]" value=""/></td>'+
                   '<td class="city" ><input class="city-input" type="text" name="citta[]" value=""/></td>'+
                   '<td class="province" ><input class="province-input" type="text" name="provincia[]" value=""/></td>'+
                   '<td class="postal_code"><input class="postal_code-input" type="text" name="cap[]" value=""/></td>'+
                   '<td class="num_racc"><input class="num_racc-input" type="text" name="numracc[]" value=""/></td>'+
                   '<td class="ar"><input class="ar-input" type="checkbox" name="ar[0]" value="on"/></td>'+
                   '<td class="weight"><input class="weight-input" type="text" name="peso[]" value="0"/></td>'+
                   '<td class="delete"><a href="#"><img src="resources/css/del_row.png" alt="Cancella riga"/></a></td>'+
               '</tr>';
      var validateForm = function()
          {
                 var berrors=true;
                 var inputs =$("#raccomandata_table tbody tr .receiver input");
                 inputs = $.merge(inputs,$("#raccomandata_table tbody tr .city input"));
                 inputs = $.merge(inputs,$("#raccomandata_table tbody tr .province input"));
                 inputs = $.merge(inputs,$("#raccomandata_table tbody tr .postal_code input"));
                 inputs = $.merge(inputs,$("#raccomandata_table tbody tr .num_racc input"));
                 inputs = $.merge(inputs,$("#raccomandata_table tbody tr .weight input"));
                 inputs.each(function(i,el){
                        if ($(el).val() == "") {
                               berrors=false;
                               $(el).addClass("wrong");
                        }
                 });
                 return berrors;
      };
      
      var addRow = function(protocol,receiver,city,province,postal_code,num_racc,ar,weight)
      {

             var oNewRow = $(sTableRow);
             protocol = protocol || '';
             receiver = receiver || '';
             city = city || '';
             province = province || '';
             postal_code = postal_code || '';
             num_racc = num_racc || '';
             ar = ar || false;
             weight = weight || '';
             
             //Pick the latest ordinal number
             var iMaxNum=0;
             $("#raccomandata_table tbody tr").each(function (index,element){
                     var iNum=$(element).children().first().text() * 1;
                     if (iNum > iMaxNum)
                             iMaxNum = iNum;
             });
             iMaxNum = iMaxNum + 1;
             
             $("#raccomandata_table tbody").append(oNewRow);
             //Add autocompletion based on geonames data
             $(oNewRow).find(".city input.city-input").val(city).autocomplete({
                      source: function( request, response ) {
                      $.ajax({
                             url: "index.php",
                             dataType: "json",
                             data: {
                             area:"auxiliary",
                             subarea:"default",
                             city:request.term
                      },
                      success: function( data ) {
                             response( $.map( data, function( item ) {
                             return {
                                           label: item.name  + " (" + item.prov_code +")"+ ", " + item.postal_code + " - " + item.region,
                                           info: item,
                                           value: item.name
                                    }
                             }));
                        }
                      });
                    },
                    autoFocus: true,
                    minLength: 2,
                    select: function( event, ui ) {
                      if (ui.item)
                      {
                          var row = $(event.target).closest("tr");
                          row.find(".province input").val(ui.item.info.prov_code).change();
                          row.find(".postal_code input").val(ui.item.info.postal_code).change();
                      }
                       
                    },
                    open: function() {
                      $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                    },
                    close: function() {
                      $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                    }
               });
              $(oNewRow).find(".counter").text(iMaxNum);
              $(oNewRow).find(".receiver input.receiver-input").val(receiver);
              $(oNewRow).find(".num_racc input.num_racc-input").val(num_racc).mask ("99999999999-9");
              $(oNewRow).find(".postal_code input.postal_code-input").val(postal_code).mask ("99999");
              $(oNewRow).find(".weight input.weight-input").val(weight).mask ("9?99999");
              $(oNewRow).find(".province input.province-input").val(province).mask ("aa");
              $(oNewRow).find(".ar input.ar-input").attr('name', "ar[" + (iMaxNum - 1) + "]").attr('checked', ar);	
              $(oNewRow).find(".protocol input.protocol-input").val(protocol).tokenfield({ delimiter: [' ',".",';',','] });

             return oNewRow;
      };
       var saveForm=function()
       {
              $.cookie("raccomandata_data",$("#rows_form").serialize());
       }
              //Initial loading management
       if ($.cookie("raccomandata_data")) {
             var sData = $.deparam($.cookie("raccomandata_data"));
             console.log(sData);
             if (sData.nonce == $("#rows_form  input[name=nonce]").val()) {
                    var iLen = sData.prot.length;
                    for (var i=0; i < iLen; i++)
                    {
                            var oRow;
                            oRow = addRow(sData.prot[i],
                                          sData.destinatario[i],
                                          sData.citta[i],
                                          sData.provincia[i],
                                          sData.cap[i],
                                          sData.numracc[i],
                                          sData.ar[i],
                                          sData.peso[i]);
                    }
             }
             else
                     addRow();
             
       }
       else
       {
              oRow = addRow();
       }
       
       $("#add_row").click(function()
       {
                    //Pick the latest ordinal number
                    /*var iMaxNum=1;
                    $("#raccomandata_table tbody tr").each(function (index,element){
                            var iNum=$(element).children().first().text() * 1;
                            if (iNum > iMaxNum)
                                    iMaxNum = iNum;
                    });
                    iMaxNum = iMaxNum + 1;
                    
                    //Pick the last row structure and clean content
                    var oNewRow = $("#raccomandata_table tbody tr:last").clone();
                    oNewRow.find("input").removeClass("wrong");
                    oNewRow.find("input[type!=checkbox]").empty();
                    oNewRow.find("input[type!=checkbox]").val('');
                    oNewRow.find(".protocol").empty().append('<input type="text" name="prot[]" value=""/>');
                    oNewRow.find("input[name^=prot]").each(function(index, element) {
                        $(element).tokenfield({ delimiter: [' ',".",';',',']});
                    });
                    oNewRow.find("input[type=checkbox]").attr('checked', false);
                    oNewRow.find("input[type=checkbox]").attr('name', "ar[" + (iMaxNum - 1) + "]");		    
                    oNewRow.find(".counter").text(iMaxNum);
                     $("#raccomandata_table tbody").append(oNewRow);*/
                    addRow();
       });
   
             $("#rows_form").submit(function(e)
             {
                     if (sStatus == "i")
                     {
                             e.preventDefault();                     
                             if (validateForm())
                             {
                                    $("#raccomandata_table tbody tr input").each(function (index,element){
                                            $(element).css("border", "1px solid transparent");
                                            $(element).attr("readonly", "readonly");	
                                    });
                                    $(".protocol input").hide();
                                    $("#confirm_rows").attr('value','Conferma');
                                    sStatus="s";
                                    $("#add_row").hide();
                                    $("#deconfirm_rows").show();
                                    $("#back").hide();
                                    $(".delete a").hide();
                                    saveForm();
                             }
                     }
                 
             });
           
             $(document).on("keypress","#raccomandata_table tbody tr input",function(e) {
                    $(this).removeClass("wrong");
             });
             $(document).on("change","#raccomandata_table tbody tr input",function(e) {
                    $(this).removeClass("wrong");
             });              
             $("#deconfirm_rows").click(function()
             {
                 
                     if (sStatus == "s")
                     {
                             sStatus="i";
                             $("#raccomandata_table tbody tr input").each(function (index,element){
                                     $(element).css("border", "1px solid rgb(200, 200, 200)");			
                                     $(element).removeAttr("readonly");
                             });
                             $(".protocol input").show();
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
       
             //$('.protocol input').tokenfield({ delimiter: [' ',".",';',',']});
             //
             //$(document).on("focus",".num_racc input", function (e)
             //{
             //      if ( !$(this).data("mask") ) {
             //             $(this).mask ("99999999999-9");      
             //      }
             //});
             //
             //$(document).on("focus",".city input", function (e)
             //{
             //      if ( !$(this).data("autocomplete") ) {
             //             $(this).autocomplete({
             //                    source: function( request, response ) {
             //                    $.ajax({
             //                           url: "index.php",
             //                           dataType: "json",
             //                           data: {
             //                           area:"auxiliary",
             //                           subarea:"default",
             //                           city:request.term
             //                    },
             //                    success: function( data ) {
             //                           response( $.map( data, function( item ) {
             //                           return {
             //                                         label: item.name  + " (" + item.prov_code +")"+ ", " + item.postal_code + " - " + item.region,
             //                                         info: item,
             //                                         value: item.name
             //                                  }
             //                           }));
             //                      }
             //                    });
             //                  },
             //                  autoFocus: true,
             //                  minLength: 2,
             //                  select: function( event, ui ) {
             //                    if (ui.item)
             //                    {
             //                        var row = $(event.target).closest("tr");
             //                        row.find(".province input").val(ui.item.info.prov_code).change();
             //                        row.find(".postal_code input").val(ui.item.info.postal_code).change();
             //                    }
             //                  },
             //                  open: function() {
             //                    $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
             //                  },
             //                  close: function() {
             //                    $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
             //                  }
             //             });
             //      }
             //});
       
       $(document).on("click",".delete a",function(e)
       {
           if ($("#raccomandata_table tbody tr").length > 1)
           {		       		    
                           var row = $(e.target).closest("tr");
                           var tbody = row.parent();
                           var counter = row.find(".counter").text();
                           $(row).remove();
       
                           $("#raccomandata_table tbody tr").each(function (index,element){		        
                                   $(element).children().first().text(index + 1);
                                    $(element).find("input[type=checkbox]").attr('name', "ar[" + index + "]");
                           });
           }
                   else
                   {
                           $("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>E' necessario  sia presente almeno una riga</p>").dialog(
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
  
      
});
