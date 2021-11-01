window.urlAjaxHandlerCms = _SERVER_PATH + '/admin/api/'; // percorso  del contenuto del  dialog

window.curItem;

window.Cms = function () {
    function handleBootstrap() {
        $('[data-toggle="tooltip"]').tooltip();

        /*Popovers*/
        jQuery('.popovers').popover();
        jQuery('.popovers-show').popover('show');
        jQuery('.popovers-hide').popover('hide');
        jQuery('.popovers-toggle').popover('toggle');
        jQuery('.popovers-destroy').popover('destroy');

        jQuery('[data-toggle="buttons-radio"]').button();
    }

    function handleToggle() {
        jQuery('.list-toggle').on('click', function () {
            jQuery(this).toggleClass('active');
        });
    }

    // checkboxes and radio
    function initCheckboxes() {


        $('input[type="checkbox"], input[type="radio"]').change(function () {
            var elem = $(this);
            if (elem.is('input[type="radio"]')) {
                $('input[type="radio"][name="' + elem.attr('name') + '"]').each(function () {
                    updateCheckbox($(this));
                });
            } else {
                updateCheckbox($(this));
            }
        }).each(function () {
            updateCheckbox($(this));
        });
    }

    function updateCheckbox(elem) {
        var checked = elem.is(':checked');
        if (checked) {
            elem.closest('.form-checkbox, .form-radio').addClass('checked');
        } else {
            elem.closest('.form-checkbox, .form-radio').removeClass('checked');
        }
    }

    function handleFlashMessage() {
        jQuery('div.flash').not('.alert-important').delay(1500).slideUp();
    }

    function listHandler() {
        $(':input[data-list-value]').on('change', function () {
            var value = $(this).val();
            var itemArray = $(this).data('list-value').split('_');
            var field = $(this).data('list-name');
            if ($(this).is(':checkbox')) {
                value = ($(this).is(":checked")) ? 1 : 0;
            }
            $.ajax({
                url: urlAjaxHandlerCms + 'update/updateItemField/' + itemArray[0] + '/' + itemArray[1],
                data: {
                    model: itemArray[0],
                    field: field,
                    value: value
                },
                type: "GET",
                dataType: 'json',
                cache: false,
                success: function (response) {
                    //  suppress
                    $.notify(response.msg, "success");
                },
                error: function (xhr, _ajaxOptions, thrownError) {
                    $.notify("Something went Wrong please" + xhr.responseJson.msg + thrownError);
                }
            });
        });

        $('[data-list-boolean]').on('click', function () {
            var itemArray = $(this).data('list-boolean').split('_');
            var field = $(this).data('list-name');
            var onObj = $(this).find(".bool-on");
            var offObj = $(this).find(".bool-off");
            var value = (onObj.hasClass('d-none')) ? 1 : 0;
            $.ajax({
                url: urlAjaxHandlerCms + 'update/updateItemField/' + itemArray[0] + '/' + itemArray[1],
                data: {
                    model: itemArray[0],
                    field: field,
                    value: value
                },
                type: "GET",
                dataType: 'json',
                cache: false,
                success: function (response) {
                    //  suppress
                    onObj.toggleClass('d-none');
                    offObj.toggleClass('d-none');
                    $.notify(response.msg, "success");
                },
                error: function (xhr, _ajaxOptions, thrownError) {
                    $.notify("Something went Wrong please" + xhr.responseJson.msg+ thrownError);
                }
            });
        });


        $('[data-role="delete-item"]').on('click', function (e) {
            e.preventDefault();
            var curItem = this;
            bootbox.setLocale(_LOCALE);
            bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
                if (confirmed) {
                    location.href = curItem.href;
                }
            });
        });

        // gestione check box liste
        $('input[type="checkbox"].custom-control-input').on('change', function () {
            if ($("input.custom-control-input:checked").length > 0)
                $('#toolbar_deleteButtonHandler').stop().fadeIn();
            else
                $('#toolbar_deleteButtonHandler').stop().fadeOut();
        });

        $('#toolbar_editButtonHandler').on('click', function (e) {
            e.preventDefault();
            //  redirect to edit page
            location.href = $('#row_' + curItem + ' [data-role="edit-item"] ')[0].href;
        });

        $('#toolbar_deleteButtonHandler').on('click', function (e) {
            e.preventDefault();
            //  redirect to edit page
            bootbox.setLocale(_LOCALE);
            bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
                if (confirmed) {
                    $('input[type="checkbox"].custom-control-input:checked').each(function () {
                        $('#row_' + $(this).val()).fadeOut('1000');
                        deleteUrl = $('#row_' + $(this).val() + ' [data-role="delete-item"] ')[0].href;
                        // Do delete
                        curModel = _CURMODEL;
                        $.ajax({
                            url: urlAjaxHandlerCms + 'delete/' + curModel + '/' + $(this).val(),
                            type: "GET",
                            dataType: 'json',
                            cache: false,
                            error: function (xhr, _ajaxOptions, thrownError) {
                                $.notify("Something went Wrong please" + xhr.responseText + thrownError);
                            }
                        });
                    });
                    $.notify("Selected items have been deleted");
                }
            });
        });
    }

    function initOverrideInvalid() {
        var offset = $('header').outerHeight() + 30;

        document.addEventListener('invalid', function (e) {
            $(e.target).addClass('invalid');
            $('html, body').animate({
                scrollTop: $($(".invalid")[0]).offset().top - offset
            }, 0);
        }, true);
        document.addEventListener('change', function (e) {
            $(e.target).removeClass('invalid');
        }, true);
    }

    function handleSidebar() {
        $('#sidebar').on('click', function (e) {
            e.stopPropagation();
        });
        $('html, body').on('click', function () {
            $('#sidebar').removeClass('open');
        });
    }

    function createCropper(container, options) {
        return new Cropper(container, options);
    }

    function updateCropper(key, cropper, file_options) {
        let canvas = cropper.getCroppedCanvas(file_options);
        let format = file_options.format || 'jpeg';
        format = 'image/' + format;
        $('#cropper-data-' + key).val(canvas.toDataURL(format));
        $('#cropper-preview-image-' + key).attr('src', canvas.toDataURL(format));
        $('#cropper-filename-' + key).val(cropper.uploadedImageName);
    }

    function updateMediaContainers(response) {
        let mediaType = response.data;
        let mediaObjContaner = (mediaType == 'images') ? "#simpleGallery" : "#simpleDocGallery";
        $(mediaObjContaner).load(urlAjaxHandlerCms + 'updateHtml/' + mediaType + '/' + _CURMODEL + '/' + $('#itemId').val());
    }

    return {
        init: function () {
            handleBootstrap();
            //handleIEFixes();
            listHandler();
            handleFlashMessage();
            handleToggle();
            handleSidebar();
            //initCheckboxes();
            initOverrideInvalid();
        },

        initDatePicker: function () {
            $(".datepicker").datepicker({
                dateFormat: "dd-mm-yy"
            });
        },

        initUploadifiveSingle: function () {
            $('.file_upload_single').each(function () {
                let elem = $(this);
                elem.uploadifive({
                    'auto': true,
                    'queueID': 'queue_' + elem.data('key'),
                    'uploadScript': urlAjaxHandlerCms + 'uploadifiveSingle',
                    'onAddQueueItem': function () {
                        this.data('uploadifive').settings.formData = {
                            'timestamp': '1451682058',
                            'token': '4b9fe8f26d865150e4b26b2a839d4f2b',
                            'Id': $('#itemId').val(),
                            'myImgType': $('#myImgType').val(),
                            'model': _CURMODEL,
                            'key': elem.data('key'),
                            "_token": $('[name=_token]').val()
                        };
                    },
                    'onUploadComplete': function (_file, data) {
                        let responseObj = jQuery.parseJSON(data);
                        let filename = responseObj.data.fullName;
                        $('[name="' + elem.data('key') + '"]').val(filename);
                    },
                    'onError': function (errorType, _file, data) {
                        let errorHtml = ''
                        let responseObj = jQuery.parseJSON(_file.xhr.response);
                        if (responseObj.status == 'KO') {
                            errorHtml = `<span style ="color:red"> ${responseObj.msg}</span>`;
                            $('.fileinfo').html(errorHtml);
                        } else errorHtml = 'The error was: ' + errorType;

                        $('.fileinfo').last().html(errorHtml);
                    }
                });
            });
        },
        initUploadifiveMedia: function () {
            let elem = $('#file_upload_media');

            elem.uploadifive({
                'auto': true,

                'queueID': 'queue_media',
                'uploadScript': urlAjaxHandlerCms + 'uploadifiveMedia',
                'onAddQueueItem': function () {
                    this.data('uploadifive').settings.formData = {
                        'timestamp': '1451682058',
                        'token': '4b9fe8f26d865150e4b26b2a839d4f2b',
                        'Id': $('#itemId').val(),
                        'myImgType': $('#myImgType').val(),
                        'model': _CURMODEL,
                        'key': elem.data('key'),
                        "_token": $('[name=_token]').val()
                    };
                },
                'onUploadComplete': function (_file, data) {
                    let responseObj = jQuery.parseJSON(data);
                    if (responseObj.status == 'KO') {
                        let errorHtml = `<span style ="color:red"> ${responseObj.msg}</span>`;
                        $('.fileinfo').html(errorHtml);
                    } else updateMediaContainers(responseObj);

                },
                'onError': function (errorType, _file, data) {
                    let errorHtml = ''
                    let responseObj = jQuery.parseJSON(_file.xhr.response);
                    if (responseObj.status == 'KO') {
                        errorHtml = `<span style ="color:red"> ${responseObj.msg}</span>`;



                    } else errorHtml = 'The error was: ' + errorType;

                    $('.fileinfo:last').html(errorHtml);;
                }

            });
        },

        initTinymce: function () {


            tinymce.init({
                selector: "textarea.wysiwyg",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor textcolor colorpicker",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste hr pagebreak help wordcount"
                ],
                pagebreak_split_block: true,
                branding: false,

                file_picker_types: 'image',
                images_upload_url: '/admin/api/upload-media-tinymce',
                images_upload_base_path: '/media/images/tinymce',
                convert_urls: false,
                height: 200,
                toolbar: "insertfile undo redo | styleselect | bold italic | bullist numlist outdent indent | link | code | pagebreak",
                convert_urls: false,
                allow_unsafe_link_target: true,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '/admin/api/upload-media-tinymce');

                    xhr.onload = function () {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        success(json.location);
                    };

                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    // append CSRF token in the form data
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    xhr.send(formData);
                }
            });
        },

        initColorPicker: function () {
            $('.color-picker').colorpicker({
                'format': 'hex'
            });
        },

        initFiles: function () {
            let inputs = $('.form-file').find('input[type="file"]');
            inputs.each(function () {
                let elem = $(this),
                    label = elem.siblings('label').first();
                elem.on('change', function () {
                    Cms.updateFile(elem, label);
                });
                elem.on('focus', function () {
                    elem.addClass('has-focus');
                });
                elem.on('blur', function () {
                    elem.removeClass('has-focus');
                });
            });
        },
        updateFile: function (elem, label) {
            let fileName = '';
            files = elem[0].files;
            if (files && files.length > 1)
                fileName = (elem.data('selected-caption') || '').replace('{count}', files.length);
            else
                fileName = elem.val().split('\\').pop();

            if (fileName)
                label.html(fileName);
            else
                label.html(elem.data('empty-caption'));
        },

        initSortableList: function (object) {
            $(object).sortable({
                revert: true,
                items: "li:not(.sort-disabled)",
                update: function () {
                    var order = $(object).sortable('serialize');
                    $("#info").load(urlAjaxHandlerCms + "updateMediaSortList?" + order);
                }
            });
            $("ul#simpleGallery").disableSelection();
        },
        initImageRelationList: function () {
            $('[data-image-relation]').on('click', function () {
                var targetField = $(this).data('image-relation');
                var targetFieldValue = $(this).data('image-id');
                $("#" + targetField).val(targetFieldValue);
                $('[data-image-relation="' + targetField + '"]').each(function () {
                    $(this).removeClass('active');
                    $(this).addClass('inactive');
                });
                $(this).addClass('active');
            });
        },
        initMediaModal: function () {
            $(document).on('submit', '#media-edit-form', function (ev) {
                ev.preventDefault();

                var fields = $(this).serializeArray();
                var fields_object = {};

                $.each(fields, function (_i, v) {
                    fields_object[v['name']] = v['value'];
                });

                if ($('#media_category_id option:selected').val())
                    media_category_title = $('#media_category_id option:selected').text();
                else
                    media_category_title = '';

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (response) {


                        let errorsHtml = '<div class="alert alert-info"><ul>';
                        errorsHtml += `<li>${response.status}</li>`; //showing only the first error.
                        errorsHtml += '</ul></div>';
                        $('#errorBox').html(errorsHtml);
                        $('.modal-body').animate({scrollTop: 0}, 200);
                        let id = '#box_media_' + fields_object.id;
                        $(id + ' .media-title').text(fields_object.title);
                        $(id + ' .media-category').text(media_category_title);
                    },
                    error: function (data) {
                        let response = data.responseJSON;
                        let errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(response.errors, function (key, value) {
                            errorsHtml += `<li>${value}</li>`;
                        });
                        errorsHtml += '</ul></div>';
                        $('#errorBox').html(errorsHtml);
                        $('.modal-body').animate({scrollTop: 0}, 200);
                    }
                });
            });
        },
        initDateTimePicker: function () {
            $('.datetimepicker').datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                hourMin: 6,
                hourMax: 22
            });
        },

        deleteImages: function (obj) {
            bootbox.setLocale(_LOCALE);
            bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
                var curItem = obj;
                var value = "";
                var itemArray = curItem.id.split('-');
                var field = itemArray[1];
                var boxObj = $("#box_" + itemArray[1] + "_" + itemArray[2]);
                var curLocale = $(obj).data('locale')

                if (confirmed) {
                    $.ajax({
                        url: urlAjaxHandlerCms + 'update/updateItemField/' + _CURMODEL + '/' + itemArray[2],
                        data: {
                            model: _CURMODEL,
                            field: field,
                            value: value,
                            locale: curLocale,
                        },
                        type: "GET",
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            // set input value as null
                            $('input[name=' + itemArray[1] + ']').val('');

                            //  suppress
                            $.notify(response.msg, "success");
                            // hide  the   media  preview  container
                            boxObj.hide();
                        },
                        error: function (xhr, _ajaxOptions, thrownError) {
                            $.notify("Something went Wrong " + xhr.responseJson.msg + thrownError);
                        }
                    });
                }
            });
        },

        deleteItem: function (obj) {
            bootbox.setLocale(_LOCALE);
            bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
                var curItem = obj;
                var itemArray = curItem.id.split('_');
                var boxObj = $("#box_" + itemArray[1] + "_" + itemArray[2]);

                if (confirmed) {
                    $.ajax({
                        url: urlAjaxHandlerCms + 'delete/' + itemArray[1] + '/' + itemArray[2],
                        type: "GET",
                        dataType: 'json',
                        cache: false,
                        success: function (response) {
                            //  suppress
                            $.notify(response.msg, "success");
                            // hide  the   media  preview  container
                            boxObj.hide();
                        },
                        error: function (xhr, _ajaxOptions, thrownError) {
                            let response = xhr.responseJSON
                            $.notify("Something went Wrong:" + response.msg + thrownError);

                        }
                    });
                }
            });
        },

        initCropper: function (key, cropper_options, file_options) {
            let container = document.getElementById('cropper-container-' + key);
            let cropper = createCropper(container, cropper_options);
            $('#cropper-upload-' + key).on('change', function () {
                var files = this.files;

                if (cropper && files && files.length) {
                    var file = files[0];
                    if (/^image\/(png|jpeg|gif)/.test(file.type)) {
                        if (cropper.uploadedImageURL) {
                            URL.revokeObjectURL(cropper.uploadedImageURL);
                        }

                        $('#cropper-toolbar-' + key).addClass('visible');

                        container.src = URL.createObjectURL(file);
                        cropper.destroy();
                        cropper = createCropper(container, cropper_options);
                        cropper.uploadedImageType = file.type;
                        cropper.uploadedImageName = file.name;
                        cropper.uploadedImageURL = container.src;

                    } else {
                        window.alert('Please choose an image file.');
                    }
                } else {
                    $('#cropper-toolbar-' + key).removeClass('visible');
                }
            });

            $('#cropper-zoom-in-' + key).on('click', (e) => {
                e.preventDefault();
                if (cropper) {
                    cropper.zoom(0.1);
                    // there is no zoom end event to call this with
                    setTimeout(function () {
                        updateCropper(key, cropper, file_options);
                    }, 100);
                }
            });
            $('#cropper-zoom-out-' + key).on('click', (e) => {
                e.preventDefault();
                if (cropper) {
                    cropper.zoom(-0.1);
                    // there is no zoom end event to call this with
                    setTimeout(function () {
                        updateCropper(key, cropper, file_options);
                    }, 100);
                }
            });
            $('#cropper-save-' + key).on('click', (e) => {
                e.preventDefault();
                if (cropper) {
                    updateCropper(key, cropper, file_options);
                    $.ajax({
                        url: urlAjaxHandlerCms + 'cropperMedia',
                        type: 'POST',
                        data: {
                            id: $('#itemId').val(),
                            image: $('#cropper-data-' + key).val(),
                            filename: $('#cropper-filename-' + key).val(),
                            myImgType: $('#myImgType').val(),
                            model: _CURMODEL,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }
                    }).done(function (response) {
                        updateMediaContainers(response);
                        cropper.destroy();
                        container.src = '';
                        $('#cropper-upload-' + key).val('').trigger('change');
                    }).fail(function (xhr, _ajaxOptions, thrownError) {
                        $.notify("Something went Wrong please" + xhr.responseText + thrownError);
                    });
                }
            });

            container.addEventListener('cropend', () => {
                updateCropper(key, cropper, file_options);
            });
            container.addEventListener('ready', () => {
                updateCropper(key, cropper, file_options);
            });
        }
    };
}();
