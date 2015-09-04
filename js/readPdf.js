var readPdf=function(btn){
				
				$.ajax({
				url:"services/ClassMagazine.php",
				type:"post",
				data:{magId:btn.id},
				success: function(response){
							//alert(response);
						//	alert('in success');
					
                              			 var path=$.parseJSON(response);
										if(path['url'])
										 $('#ifrm').attr('src', path['url']);
										 
					 					
					},
					error: function(response, status, errorThrown) {
                       //alert('in error');
					   //alert(response);
                                         
                    console.log(response.status);
                    //alert(errorThrown);
					}
				
				});
					
				}