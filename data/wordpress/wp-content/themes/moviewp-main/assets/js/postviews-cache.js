jQuery.ajax({type:"GET",url:viewsCacheL10n.ajaxurl,data:"postviews_id="+viewsCacheL10n.post_id+"&action=postviews",cache:!1,success:function(b){b&&jQuery("#views span").html(b+viewsCacheL10n.textviews)}});