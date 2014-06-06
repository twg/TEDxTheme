var Styleguide = function() {

  var sg = this 

  sg.data = []
  sg.painters = []

  // extract styleguide comments from stylesheet
  sg.init = function(s){
    $.when($.get(s)).done(function(response) {
      var expression = /\/\*\!\!\!([\s\S]*?)\*\//mg
      var match
      while ((match = expression.exec(response)) != null){
        match = parse_yaml(scrub_comments(match[1]))
        if (new_section(match.section)){
          sg.data[match.section] = new Array()
        }
        sg.data[match.section][match.title] = match
      }
      render()
    });
  }

  // loop through and output data as html
  var render = function(){
    $('body').trigger('preRender')
    var html = ''
    for(section in sg.data){
      html += '<section class="sg"><a id="'+section+'"></a><h2 class="sg">'+section+'</h2>'  
      for(section_item in sg.data[section]){
        section_item = sg.data[section][section_item]
        html += '<div class="sg-item">'
        for(key in section_item){
          html += sg.painters[key](section_item[key])
        }
        html += '</div>'
      }
      html += '</section>'  
    }
    html += nav()
    $('body').html(html).trigger('postRender')
  }

  // generate navigation
  var nav = function(){
    var html = '<nav class="sg">'
    for(section in sg.data){
      html += '<a href="#'+ section +'">' + section + '</a>'
    }
    html += '</nav>'
    return html 
  }

  // render titles
  sg.painters.title = function(s){
    return '<h3 class="sg">'+s+'</h3>'
  }

  // render sections
  sg.painters.section = function(s){
    return ''
  }

  // render descriptions
  sg.painters.description = function(s){
    return markdown.toHTML(s)
  }

  // render swatches
  sg.painters.swatches = function(s){
    var output = '<div class="sg-swatches">'
    for (key in s){
      value = s[key]
      output += '<div class="sg-swatch">'
      output += '<div class="sg-swatch-sample" style="background-color:#'+value+'">'
      output += '</div>'
      output += '<div class="sg-swatch-info">'
      output += '<span class="sg-swatch-key">' + key + '</span> <span class="sg-swatch-value">#' + value + '</span>'
      output += '</div>'
      output += '</div>'
    }
    output += '</div>'
    return output 
  }

  // render example code
  sg.painters.example = function(s){
    var code = $('<span/>').text(s).html()
    code = '<pre><code>'+code+'</code></pre>'
    s = '<div class="sg-code-output">' + s + '</div>'
    return '<div class="sg-code">' + s + code + '</div>'
  }
  $(document).ready(function(){
    $('body').on('postRender', function(){
      $('pre code').each(function(i, e) {hljs.highlightBlock(e)})
    })
  });

  // determine if the section in question already exists
  var new_section = function(section){
    for (key in sg.data){
      if(section === key){
        return false
      }
    }
    return true
  }

  // prep string for YAML parser but cleaning up white-space and comment marks
  var scrub_comments = function(match){
    match = match.replace(/\ *\*\ /g, '')
    match = match.replace(/\#/g, '')
    return match
  }

  // parse string as YAML
  var parse_yaml = function(match){
    return jsyaml.load(match)
  }
}
var sg = new Styleguide()
