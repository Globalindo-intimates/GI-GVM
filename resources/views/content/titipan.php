$(document).ready(function () {
            $.ajax({
                url: '{{url('/getdata')  }}',
                type: 'GET',
                dataType: 'JSON',
                success: function (response) {
                    $('#no_polisi').empty()
                    let $select = $('#no_polisi');
                    let no_polisi = [];
                    $select.empty().append('<option></option>');

                    $.each(response.data, function (i, item) {
                        $select.append($('<option>', {
                            value: item.no_polisi,
                            text: item.no_polisi,
                        }))
                    })
                    $select.select2({
                        theme: 'bootstrap-5',
                        text: 'false',
                        placeholder: 'Pilih Nomor Polisi',
                    })

                    $('#no_polisi').on('change', function () {
                        let id = $(this).val()
                        $.ajax({
                            url: '{{url('/getmasterdata')  }}',
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                id: id,
                            },
                            success: function (response) {
                                let item = response.data[0];
                                console.log( response);
                                $('#merk').val(item.merk);
                                $('#tahun').val(item.tahun)
                                $('#jenis').val(item.jenis);
                            }
                        })
                    });

                }

            })
        })

// $('#simpan').on('click', function() {
                        
                    //     FormData.append
                    //     $.ajax({
                    //         url:'{{ url('/simpanajax') }}',
                    //         type: 'POST',
                    //         data: {

                    //         }
                    //     })
                    // })


                    id = "my-table"
                    $('#my-table').DataTable({

        });