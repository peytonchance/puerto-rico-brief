var AEEData;
var dateArray = [];
var powerArray = [];

function loadAEEData(){
  $.ajax({
      type: "GET",
      url: "data/aee-data.json",
      dataType: "json",
      success: parseAEEData
    });
}

function parseAEEData(AEEData){
  for (var i=0; i < AEEData.length; i++)
  {
    dateArray.push(AEEData[i]["Date"]);
    powerArray.push(AEEData[i]["Percentage"]);
  }
  buildAEEGraph();
}

function buildAEEGraph(){
  var aeeGraph = c3.generate({
    bindto: '#aee-graph',
      padding: {
  top: 20
},
    data: {
        x:'x',
        xFormat: '%m-%d-%Y',
        columns: [
            dateArray,
            powerArray
        ],
        types: {
          Percentage: 'area-spline'
        },
        names: {
          percentage: 'Percentage of Electricity Operating'
  }
    },
    axis: {
        x: {
            type: 'timeseries',
            format: '%m-%d-%Y'
        },
        y:{
              tick:{
                format: d3.format('%')
            },
            max: 1,
            min: 0,
            padding: 0
        }
    }
});
}
// News API
function getCNNFeed(){
  var CNNurl = 'https://newsapi.org/v2/everything?' +
            'sources=cnn&' +
            'q=PuertoRico&' +
            'from=2017-05-20&' +
            'sortBy=popularity&' +
            'apiKey=' + myNewsKey;

            $.ajax({
                    type:"GET",
                    url: CNNurl,
                    dataType:"json",
                    success: parseCNNData
        });
}

function parseCNNData(CNNdata){
  console.log(CNNdata);
  var html = "<div>";
  var html = "<h3>CNN on Puerto Rico</h3>"
  var articles = CNNdata["articles"];

  for(var i=0, len = articles.length; i < len; i++){
    var tempId = articles[i]["title"];
    html += '<a target="_blank" href="' + articles[i]["url"] + '"><h4>' + articles[i]["title"] + '</h4></a>';
    html += '<p>' + articles[i]["description"] + '</p>';
  }
  html+= '</div>'
  $("#cnn-feed").html(html);
  $('#cnn-feed').removeClass("hide");
  $("#wp-feed").addClass("hide");
  $("#fox-feed").addClass("hide");
}

function getFOXFeed(){
  var FOXurl = 'https://newsapi.org/v2/everything?' +
            'sources=fox-news&' +
            'q=PuertoRico&' +
            // 'from=2017-05-20&' +
            'sortBy=popularity&' +
            'apiKey=' + myNewsKey;

            $.ajax({
                    type:"GET",
                    url: FOXurl,
                    dataType:"json",
                    success: parseFOXData
        });
}

function parseFOXData(FOXdata){
  console.log(FOXdata);
  var html = "<div>";
  var html = "<h3>FOX News on Puerto Rico</h3>"
  var articles = FOXdata["articles"];

  for(var i=0, len = articles.length; i < len; i++){
    var tempId = articles[i]["title"];
    html += '<a target="_blank" href="' + articles[i]["url"] + '"><h4>' + articles[i]["title"] + '</h4></a>';
    html += '<p>' + articles[i]["description"] + '</p>';
  }
  html+= '</div>'
  $("#fox-feed").html(html);
  $('#fox-feed').removeClass("hide");
  $("#cnn-feed").addClass("hide");
  $("#wp-feed").addClass("hide");
}

function getWPFeed(){
  var WPurl = 'https://newsapi.org/v2/everything?' +
            'sources=the-washington-post&' +
            'q=PuertoRico&' +
            'from=2017-05-20&' +
            'sortBy=popularity&' +
            'apiKey=' + myNewsKey;

            $.ajax({
                    type:"GET",
                    url: WPurl,
                    dataType:"json",
                    success: parseWPData
        });
}

function parseWPData(WPdata){
  console.log(WPdata);
  var html = "<div>";
  var html = "<h3>The Washington Post on Puerto Rico</h3>"
  var articles = WPdata["articles"];

  for(var i=0, len = articles.length; i < len; i++){
    var tempId = articles[i]["title"];
    html += '<a target="_blank" href="' + articles[i]["url"] + '"><h4>' + articles[i]["title"] + '</h4></a>';
    html += '<p>' + articles[i]["description"] + '</p>';
  }
  html+= '</div>'
  $("#wp-feed").html(html);
  $('#wp-feed').removeClass("hide");
  $("#cnn-feed").addClass("hide");
  $("#fox-feed").addClass("hide");
}



loadAEEData();
// getCNNFeed();
// getFOXFeed();
// getWPFeed();
