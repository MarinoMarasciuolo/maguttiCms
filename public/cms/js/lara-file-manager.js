(()=>{var e=!1;$((function(){var a=$("#filemanager");$(".filemanager-select").on("click",(function(e){e.preventDefault(),a.modal("show");var i=$(this).data("input"),n=$("input[name="+i+"]").val();0!=n?(window.$eventBus.$emit("FILE_MANAGER_SELECT_ITEM",n),window.$eventBus.$emit("FILE_MANAGER_LOAD_LIST",n),$("#file-manager-list").click()):(window.$eventBus.$emit("FILE_MANAGER_LOAD_LIST",n),window.$eventBus.$emit("FILE_MANAGER_SELECT_ITEM",null)),$("input[name=file-input]",a).val(i),$("input[name=file-value]",a).val(n)})),$("input[name=upload-input]",a).uploadifive({auto:!0,queueID:"queue-modal",uploadScript:urlAjaxHandlerCms+"filemanager/upload",onAddQueueItem:function(e){this.data("uploadifive").settings.formData={_token:$("[name=_token]").val()}},onUploadComplete:function(i,n){var t=jQuery.parseJSON(n);t.data;$("input[name=file-value]",a).val(t.id),e=!0,$("#file-manager-list").trigger("click")}}),$("#file-manager-list").on("click",(function(i){var n=$(".filemanager-select").data("input"),t=parseInt($("input[name="+n+"]").val())?parseInt($("input[name="+n+"]").val()):"";"".concat(urlAjaxHandlerCms,"filemanager/list/").concat(t);window.$eventBus.$emit("FILE_MANAGER_LOAD_LIST",t);var l=$("input[name=file-value]").val();$(".modal-footer",a).removeClass("visually-hidden"),0!=l&&($("#file-manager-upload",a).removeClass("active"),$("#file-manager-list",a).addClass("active"),$("#tab-upload",a).removeClass("active show"),$("#tab-images",a).addClass("active show"),$("#media-id-"+l).addClass("active"),1!=e&&window.$eventBus.$emit("FILE_MANAGER_LOAD_LIST",l),window.$eventBus.$emit("FILE_MANAGER_SELECT_ITEM",l),window.$eventBus.$emit("FILE_MANAGER_UPDATE_SIDE_BAR",l),e=!1)})),$(document).on("submit","#filemanager-edit-form",(function(e){e.preventDefault();var a=$(this);$.ajax({type:"POST",url:a.attr("action"),data:a.serialize(),dataType:"json",success:function(e){$.notify(e.message,"success"),$("#file-manager-list").trigger("click")},error:function(e){$.notify("Error.")}})})),$(".reset-image",a).on("click",(function(e){e.preventDefault(),window.$eventBus.$emit("FILE_MANAGER_RESET")})),$(".confirm-image",a).on("click",(function(e){e.preventDefault(),$("input[name="+$("input[name=file-input]",a).val()+"]").val($("input[name=file-value]",a).val()),a.modal("hide")})),$("#filemanager").on("hidden.bs.modal",(function(){$("#tab-upload",a).addClass("active show"),$("#tab-images",a).removeClass("active show"),$("#file-manager-upload",a).addClass("active"),$("#file-manager-list",a).removeClass("active"),$("#sidebar-content").html("")}))}))})();