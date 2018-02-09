$(function() {
    var count1 = $("#count").val();
    var num = $("#ren").val();
    var count2 = num - count1;
    if (count1=="0") {
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [{
                label: "大吉大利",
                value: num
            }],
            resize: true,
            colors: ['#00a513'],
            ymax: 'auto 10', 
        });

    }else{
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [{
                label: "非正常上课",
                value: count1
            }, {
                label: "正常上课",
                value: count2
            }],
            resize: true,
            colors: ['#ea2000', '#54cdb4','#1ab394'],
            ymax: 'auto 10', 
        });
    }

   
});
