function init(address)
{
                 $('#contact_jump').find('a').toggle(function(){
                        var element=$(this);
                                              
                       $('.overlay_contact').animate({                         
                          height:'410px'
                        },400);
                       
                        element.animate({ marginTop:'-15px'},200).text("fechar");

                       
                      element.parent().animate({
                          top:'-235%',
                          height:'403px'
                        },400,function(){                        
                             
                        });  
                 
                },function(){
                      var element=$(this);
                        $('.overlay_contact').animate({                         
                          height:'0px'
                        },400);
                                             
                       element.parent().animate({                           
                           top:'-9%',
                            height:'7px'
                        },700);  
                            $('#contact_jump a').animate({ marginTop:'225px'},500);                            
                              $('#contact_jump a').animate({ marginTop:'0px'},700).text("contato");   
                        
                });
             
             

}