<!--             <div class="ui container" style="margin-right: auto; margin-left: auto;">
                <canvas id="ldnLsaChart" style="height: 200px; width: 1000px;"></canvas>
            </div> -->
        <?php 
if ($lsa_rows !== 0){
        ?>
<h3>DEFINITIONS</h3>
 <table class="ui very basic collapsing celled striped table center aligned" style="font-family: Playfair Display; ">
    <tr>
        <th style="text-align: center;">Learning Style</th>
        <th style="text-align: center;">Descrription</th>
    </tr>
    <tr>
        <td>
            ACTIVIST
        </td>
        <td>
            <p>Activist involve thenselves fully and without bias in new experiences. They enjoy the here and now and are happy to be dominated by immediate experiences. They are open minded, not skeptical. Their philosophy is: "I'll try anything once". They dash were angels fear to tread and revel in short term crisis, firefighting and tackle problems by brain storming. They tend to thrive on the challenge of new experiences but are bored with implementation and long-term consolidation. They are the life and soul of the part and seek to center all activities around themselves.</p>
        </td>
    </tr>
    <tr>
        <td>
            REFLECTOR
        </td>
        <td>
            <p>Reflectors like to stand back and ponder experiences and observe them from many different perspectives. They collect data, both first hand from others, and prefer to chew it over thoroughly before concluding. Their philosophy is to be cautious and leave no stone unturned. "Look before you leap"; "Sleep on it".They prefer to take the back seat in meetings and discussions. They enjoy in observing other people in action. They tend to adopt a low profile and have a slightly distant, tolerant, unruffled air about them. When they act it is part of a wider picture which includes the past as well as the present and both their own and others observations.</p>
        </td>
    </tr>
    <tr>
        <td>
            THEORIST
        </td>
        <td>
            <p>Theorists adapt and integrate observations into complex but logically sound theories. They think problems through in a vertical, step by step, logical way. They tend to be perfectionist, who won't rest easy until things are tidy and fit into their rational scheme. They are keen on basic assumptions, principles, theories, models and systems thinking. Their philosophy prizes rationality and logic. "If its logical its good". Their approach to problemsis consistently logical and they prefer to maximize certainty and feel uncomfortable with subjective judgements, lateral thinking and anything flippant.</p>
        </td>
    </tr>
    <tr>
        <td>
            PRAGMATIST
        </td>
        <td>
            <p>Pragmatist are keen on trying out ideas, theories and techniques to see if they work in practice. They are the sort of people who return from management courses brimming with new ideas that they want to try out in practice. They like to get on with things and act quickly and confidently on ideas that attract them. They are essentiallt practical, down to earth people who like making practical decisions and solving problems. They respond to problems and opportunities as a challenge. Their philosophy is: "There is always a better way" and "If it works then its good".</p>
        </td>
    </tr>
</table>
<?php
    }
?>
<div class="ui mini modal lsa_dsc_modal" style="top: 200px !important;">
  <!-- <div class="header">Header</div> -->
    <i class="close icon"></i>
  <div class="content">
    <p class="lsa_dsc"></p>
  </div>
  <!-- <div class="actions">
    <div class="ui approve button">Approve</div>
    <div class="ui button">Neutral</div>
    <div class="ui cancel button">Cancel</div>
  </div> -->
</div>


<script type="text/javascript">

    

     var ctx = document.getElementById("ldnLsaChart");
     var config = {
                        type: 'bar',
                        data: {
                            labels: [
                            "Activist",
                            "Reflector",
                            "Theorist",
                            "Pragmatist",
                            ],
                            datasets: [{
                                label: 'Score',
                                data: 
                                <?php     
                                    echo "[";
                                    echo "\"".$activist."\",";
                                    echo "\"".$reflector."\",";
                                    echo "\"".$theorist."\",";
                                    echo "\"".$pragmatist."\",";
                                    echo "]";
                                ?>,
                                backgroundColor: [
                                // '#ffa500',
                                // '#00ffe2',
                                // '#7fff00',
                                // '#8a2be2'
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                ],
                                borderColor: [
                                
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(75, 192, 192, 1)',
                                ],
                                borderWidth: 1,
                            }]
                        },
                        options: {

onClick: function (e,arr){
    if (arr.length !== 0) {



        console.log();


        label = arr[0]._chart.config.data.labels[arr[0]._index];
        // console.log(label);
        score = arr[0]._chart.config.data.datasets[0].data[arr[0]._index];

        $('.lsa_dsc').html("");
        if (label === "Activist") {
            $('.lsa_dsc').html("<b style='color:teal'>Activist</b> involve themselves fully and without bias in new experiences. They enjoy the here and now and are happy to be dominated by immediate experiences. They are open minded, not skeptical. Their philosophy is: <b>\"I'll try anything once\"</b>. They dash were angels fear to tread and revel in short term crisis, firefighting and tackle problems by brain storming. They tend to thrive on the challenge of new experiences but are bored with implementation and long-term consolidation. They are the life and soul of the part and seek to center all activities around themselves.");
        } else if (label === "Reflector"){
            $('.lsa_dsc').html("<b style='color:teal'>Reflectors</b> like to stand back and ponder experiences and observe them from many different perspectives. They collect data, both first hand from others, and prefer to chew it over thoroughly before concluding. Their philosophy is to be cautious and leave no stone unturned. <b>\"Look before you leap\"; \"Sleep on it\"</b>. They prefer to take the back seat in meetings and discussions. They enjoy in observing other people in action. They tend to adopt a low profile and have a slightly distant, tolerant, unruffled air about them. When they act it is part of a wider picture which includes the past as well as the present and both their own and others observations.");
        } else if (label === "Theorist"){
            $('.lsa_dsc').html("<b style='color:teal'>Theorist</b>  adapt and integrate observations into complex but logically sound theories. They think problems through in a vertical, step by step, logical way. They tend to be perfectionist, who won't rest easy until things are tidy and fit into their rational scheme. They are keen on basic assumptions, principles, theories, models and systems thinking. Their philosophy prizes rationality and logic. <b>\"If its logical its good\"</b>. Their approach to problemsis consistently logical and they prefer to maximize certainty and feel uncomfortable with subjective judgements, lateral thinking and anything flippant.");
        } else if (label === "Pragmatist"){
            $('.lsa_dsc').html("<b style='color:teal'>Pragmatist</b> are keen on trying out ideas, theories and techniques to see if they work in practice. They are the sort of people who return from management courses brimming with new ideas that they want to try out in practice. They like to get on with things and act quickly and confidently on ideas that attract them. They are essentiallt practical, down to earth people who like making practical decisions and solving problems. They respond to problems and opportunities as a challenge. Their philosophy is: <b>\"There is always a better way\"</b> and <b>\"If it works then its good\"</b>.");
        }
        
        $('.lsa_dsc_modal').modal({
            transition: 'fade',

        }).modal('show');

        $(this).popup({
            popup : $('.lsa_dsc'),
            on    : 'click'
        });

    }
},

 scales: {
     yAxes: [{
         scaleLabel: {
             display: true,
             labelString: 'Score'
         },
         ticks: {
             beginAtZero:true,
             max: 5,
             stepSize: 1
         }
     }]
 },//end of scales

 title: {
         display: true,
         text: "Learning Style"
     },
 legend: {
         display: false,  
     },

    }
};
var ldnLsaCharts = new Chart(ctx, config);

</script>

