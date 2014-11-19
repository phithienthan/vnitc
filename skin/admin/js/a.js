

// see http://code.stephenmorley.org/javascript/running-tasks-on-load/
var runOnLoad=(function(){var y,s=[],w=window,d=document,l='addEventListener',h='attachEvent';function r(){for(y=1;s.length;)s.shift()()}d[l]?(d[l]('DOMContentLoaded',r,0),w[l]('load',r,0)):(d[h]('onreadystatechange',function(){d.readyState=='complete'&&r()}),w[h]('onload',r));return function(t){y?t():s.push(t)}})();

// create the Website object
var Website = (function(){

  // define the list of sharing buttons


  // the nodes
  var pageNavigationNode;
  var sharingButtonsNode;

  // the section offsets
  var sectionOffsets = [];

  // Initialise the dynamic features.
  function initialise(){

    // store references to the notes
    pageNavigationNode = document.getElementById('pageNavigation');
    sharingButtonsNode = document.getElementById('sharingButtons');

    // loop over the headings, storing the section offsets
    var headings = document.getElementsByTagName('h2');
    for (var i = 0; i < headings.length; i ++){
      sectionOffsets.push(headings[i].offsetTop + 116);
    }

  }

  // Handles the page being scrolled.
  function handleScroll(){

    // determine the distance scrolled
    var offset = document.documentElement.scrollTop || document.body.scrollTop;

    // set the appropriate class on the page navigation
    pageNavigationNode.className = (offset > 72 ? 'fixed' : '');

    // determine which section is being viewed
    var section = -1;
    for (var i = 0; i < sectionOffsets.length; i ++){
      if (offset > sectionOffsets[i]) section = i;
    }

  }



  /* Handles a sharing button being clicked. The parameter is:
   *
   * buttonDetails - the button details
   */
  function handleSharingButtonClick(buttonDetails){

    // determine the URL
    var finalUrl =
        buttonDetails.url.replace(
            '<url>', encodeURIComponent(location.href));
    finalUrl = finalUrl.replace('<title>', encodeURIComponent(document.title));

    // open the URL
    if (buttonDetails.width == 0 || buttonDetails.height == 0){
      location.href = finalUrl;
    }else{
      window.open(
          finalUrl,
          '_blank',
          'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width='
              + buttonDetails.width
              + ',height='
              + buttonDetails.height);
    }

  }

  // add the listeners
  window.addEventListener('scroll', handleScroll, false);

  // initialise on load
  runOnLoad(initialise);


})();
