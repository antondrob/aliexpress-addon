jQuery(document).ready(function ($) {
    $('#ali-data').on('click', function (e) {
        e.preventDefault();
        const button = $(this);
        $.ajax({
            url: ali.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'vi_wad_override_product',
                step: 'check',
                override_product_url: $('#aliexpress-product').val(),
                replace_description: 0
            },
            beforeSend: () => {
                $('#aliexpress-api-data').html('');
                button.text('Getting...');
            },
            success: (response) => {
                if (response.status === 'success') {
                    const data = JSON.parse(response.data);
                    console.log(data);
                    if (data.variations?.length) {
                        $('#aliexpress-api-data').append('<ol></ol>');
                        data.variations.forEach((el) => {
                            console.log(el);
                            const variation_ids = Object.values(el.variation_ids);
                            $('#aliexpress-api-data ol').append(`<li>
                                <b>${variation_ids.join(', ')}</b>:<br>
                                Var ID: ${el.skuId}<br>
                                Var Attr: ${el.skuAttr}<br>
                            </li>`);
                        });
                    }
                } else {
                    if (data.message !== 'undefined') {
                        alert(data.message);
                    } else {
                        console.log(response);
                        alert('See response in console.');
                    }
                }
            },
            complete: () => {
                button.text('Get data');
            }
        });
    });
});