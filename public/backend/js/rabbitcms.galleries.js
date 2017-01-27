define(["jquery"], function ($) {
    "use strict";

    function table(portlet) {
        var dataTable = new Datatable();
        var tableSelector = $('#galleries_table', portlet);

        dataTable.setAjaxParam('_token', _TOKEN);
        dataTable.init({
            src: tableSelector,
            dataTable: {
                ajax: {
                    url: tableSelector.data('link')
                },
                order: [
                    [0, 'desc']
                ],
                columnDefs: [
                    {
                        targets: 'fixed',
                        orderable: false
                    },
                    {
                        targets: 'actions',
                        render: function (data, type, row, meta) {
                            return '<a class="btn btn-sm green" href="' + data.edit + '" rel="ajax-portlet"><i class="fa fa-search"></i></a> ' +
                                '<a class="btn btn-sm red" href="' + data.delete + '" rel="delete"><i class="fa fa-trash-o"></i></a> ';
                        }
                    }
                ]
            }
        });

        tableSelector.on('change', '.form-filter', function () {
            dataTable.submitFilter();
        });

        MicroEvent.bind('dt.update', function () {
            dataTable.getDataTable().ajax.reload(null, false);
        });

        portlet.on('click', '[rel="delete"]', function () {
            var self = $(this);
            var link = self.attr('href');

            RabbitCMS.Dialogs.onDelete(link, function () {
                MicroEvent.trigger('dt.update');
            });

            return false;
        });

        portlet.on('click', '[rel="create"]', function () {
            var self = $(this);
            var link = self.attr('href');

            RabbitCMS.loadModalWindow(link, function (modal) {
                var form = $('form', modal);

                form.validate({
                    focusInvalid: true,
                    rules: {
                        "caption": {
                            required: true
                        }
                    },
                    highlight: function (element) {
                        $(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    },
                    errorPlacement: function (error, element) {
                        return false;
                    },
                    submitHandler: function (form) {
                        RabbitCMS.submitForm(form, function (data) {
                            MicroEvent.trigger('dt.update');

                            modal.modal('hide');

                            setTimeout(function () {
                                modal.remove();
                            }, 1000);

                            RabbitCMS.navigate('/galleries/galleries/edit/' + data.id);
                        });
                    }
                });
            });

            return false;
        });
    }

    function update(portlet) {
        var form = $('form', portlet);

        form.validate({
            focusInvalid: true,
            rules: {
                "caption": {
                    required: true
                },
                "active": {
                    required: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorPlacement: function (error, element) {
                return false;
            },
            submitHandler: function (form) {
                RabbitCMS.submitForm(form, function (data) {
                    MicroEvent.trigger('dt.update');
                });
            }
        });

        $('#fileupload-input', portlet).fileupload({
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);

            $('.fileupload-progress', portlet)
                .removeClass('hidden');
            $('#fileupload-progress-bar .progress-bar', portlet)
                .css('width', progress + '%');

            if (progress == 100) {
                setTimeout(function () {
                    $('.fileupload-progress', portlet)
                        .addClass('hidden');
                }, 1000);
            }
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                var template = $('#uploaded-files-container-row', portlet).html();

                var result = template.replace('__PATH__', file.path)
                    .replace('__CAPTION__', file.caption)
                    .replace('__TITLE__', file.caption)
                    .replace('__ID__', file.id)
                    .replace('__DELETE__', file.delete);

                $('#uploaded-files-container', portlet).append(result);

                MicroEvent.trigger('colorbox.update');
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index, file) {
                $('#error-container', portlet)
                    .append('<div class="alert alert-danger">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' +
                        '<strong>Помилка!</strong> Файл ' + file.name + ' не завантажено.</div>');
            });
        });

        $('#uploaded-files-container', portlet).sortable({
            items: 'tr',
            axis: 'y',
            opacity: 0.8,
            placeholder: "ui-state-highlight",
            tolerance: "pointer",
            start: function(e, ui){
                ui.placeholder.height(ui.item.height());
            },
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                }).css({'background-color': '#f9f9f9', 'border': '1px solid #ddd'});

                return ui;
            },
            update: function (event, ui) {
                MicroEvent.trigger('colorbox.update');
            }
        });

        $('.gallery-item', portlet).colorbox({
            rel: 'gallery-item',
            width: '75%',
            height: '75%'
        });

        MicroEvent.bind('colorbox.update', function () {
            $.colorbox.remove();

            $('.gallery-item', portlet).colorbox({
                rel: 'gallery-item',
                width: '75%',
                height: '75%'
            });
        });

        portlet.on('click', '[rel="delete-file"]', function () {
            var self = $(this);
            var link = self.attr('href');

            RabbitCMS.Dialogs.onDelete(link, function () {
                self.parents('tr')
                    .remove();

                MicroEvent.trigger('colorbox.update');
            });

            return false;
        });

    }

    var MicroEvent = new RabbitCMS.MicroEvent({table: table, update: update});

    return MicroEvent;
});