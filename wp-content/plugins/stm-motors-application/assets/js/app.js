(function($) {
    $(document).ready(function() {
        //$('#stmMATabs li:nth-child(1) a').tab('show');

        $('input[name="grid_view"]').on('change', function() {
            $('.radio-wrap').removeClass('grid-checked');
            $(this).parent().parent().addClass('grid-checked');
        });

        $('input[name="main_color"]').wpColorPicker({
            defaultColor: '#1bc744',
            change: function(event, ui){ },
            clear: function(){ },
            hide: true,
            palettes: false
        });

        $('input[name="second_color"]').wpColorPicker({
            defaultColor: '#2d60f3',
            change: function(event, ui){ },
            clear: function(){ },
            hide: true,
            palettes: false
        });

        var optMap = [];

        $('#filter-select').multiSelect({
            keepOrder: true,
            afterSelect: function (val) {
                if(optMap.length == 0) {
                    optMap = val;
                } else {
                    optMap.push(val[0]);
                }
                $('input[name="filter-opt"]').val(optMap.toString());
            },
            afterDeselect: function (val) {
                var index = optMap.indexOf(val[0]);
                if (index > -1) {
                    optMap.splice(index[0], 1);
                }
                $('input[name="filter-opt"]').val(optMap.toString());
            }
        });

        $('#step_one-select').multiSelect({
            keepOrder: true,
            afterSelect: function (val) {
                var get_val = $('input[name="step_one-opt"]').val();
                var hidden_val = (get_val != "") ? get_val+"," : get_val;

                $('input[name="step_one-opt"]').val(hidden_val+""+val);
            },
            afterDeselect: function (val) {
                var get_val = $('input[name="step_one-opt"]').val();
                var new_val = get_val.replace(val + ',', "");
                new_val = new_val.replace(val, "");

                $('input[name="step_one-opt"]').val(new_val);

            }
        });

        $('#step_two-select').multiSelect({
            keepOrder: true,
            afterSelect: function (val) {
                var get_val = $('input[name="step_two-opt"]').val();
                var hidden_val = (get_val != "") ? get_val+"," : get_val;

                $('input[name="step_two-opt"]').val(hidden_val+""+val);
            },
            afterDeselect: function (val) {
                var get_val = $('input[name="step_two-opt"]').val();
                var new_val = get_val.replace(val + ',', "");
                new_val = new_val.replace(val, "");

                $('input[name="step_two-opt"]').val(new_val);
            }
        });

        $('#step_three-select').multiSelect({
            keepOrder: true,
            afterSelect: function (val) {
                var get_val = $('input[name="step_three-opt"]').val();
                var hidden_val = (get_val != "") ? get_val+"," : get_val;

                $('input[name="step_three-opt"]').val(hidden_val+""+val);
            },
            afterDeselect: function (val) {
                var get_val = $('input[name="step_three-opt"]').val();
                var new_val = get_val.replace(val + ',', "");
                new_val = new_val.replace(val, "");

                $('input[name="step_three-opt"]').val(new_val);
            }
        });

        if(filterParams.length > 0) {
            $('#filter-select').multiSelect('select', filterParams);
        }

        console.log(stepOne);
        console.log(stepTwo);
        console.log(stepThree);

        if(stepOne.length > 0) {

            $('#step_one-select').multiSelect('select', stepOne);
            $('#step_one-select').multiSelect('refresh');
        }
        if(stepTwo.length > 0) {
            $('#step_two-select').multiSelect('select', stepTwo);
            $('#step_two-select').multiSelect('refresh');
        }
        if(stepThree.length > 0) {
            $('#step_three-select').multiSelect('select', stepThree);
            $('#step_three-select').multiSelect('refresh');
        }
    });
})(jQuery);