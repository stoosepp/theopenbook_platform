window.onload = function() {
   loadCheckboxes();
   setCurrentPageLink();
   setupSmoothScroll();
}

function loadCheckboxes(){
    var list = document.querySelectorAll(`[type*="checkbox"]`);
    //console.log("There are " + list.length + ' checkboxes to check');
    list.forEach( el => {
        var checked = JSON.parse(localStorage.getItem(el.id));
        console.log(el.id + ' is checked: ' + checked);
        if (checked){
            var checkBox = document.getElementById(el.id);
            checkBox.checked = checked;
            if (el.id == 'tufte'){
                updateCSS(el,checked,true);
            }
            else if (el.id == 'accessible'){
                updateCSS(el,checked,true);
            }
            else if (el.id == 'darkmode'){
                updateCSS(el,checked,true);
            }
            else if (el.id == 'hamburger-hidden'){
                console.log('Setting up side menu');
                //hide and show menu stuff
                leftTOC = document.getElementsByClassName('left-toc')[0];
                leftTOC.classList.add('disable-css-transitions');
                leftTOC.classList.add('hidden-toc');
                //leftTOC.classList.remove('disable-css-transitions');

                article = document.getElementsByClassName('article')[0];
                article.classList.add('disable-css-transitions');
                article.classList.add('hidden-toc2');
                //article.classList.remove('disable-css-transitions');

                headerBar = document.getElementsByClassName('header-bar')[0];
                headerBar.classList.add('disable-css-transitions');
                headerBar.classList.add('headerbar-padding');
                //headerBar.classList.remove('disable-css-transitions');


                menuTrigger = document.getElementsByClassName('bt-menu-trigger')[0];
                menuTrigger.getElementsByTagName('span')[0].classList.add('disable-css-transitions');
                menuTrigger.classList.remove('bt-menu-open');
                //menuTrigger.classList.remove('disable-css-transitions');
            }
            
        }
    });
    document.body.style.visibility = 'visible';
  document.body.style.opacity = 1;
} 



function saveCheckbox(thisCheckbox){
    console.log('ID is: ' + thisCheckbox.id);  
    if (thisCheckbox.checked == true){
        localStorage.setItem(thisCheckbox.id, true);
        console.log('Saved ' + thisCheckbox.id,true);
    } 
    else{
        localStorage.setItem(thisCheckbox.id, false);
        console.log('Saved ' + thisCheckbox.id,false);
    }

    if ((thisCheckbox.id == 'tufte') || (thisCheckbox.id == 'accessible') || (thisCheckbox.id == 'darkmode'))
    {
        updateCSS(thisCheckbox, thisCheckbox.checked, true);   
    }
}

async function updateCSS(forToggle, isChecked, onPageLoad)
{
    var bookURL = bookSSURL.templateUrl;
    var body = document.body
    if ((forToggle.id != 'darkmode') && (onPageLoad == false)){
        body.classList.toggle('fade');
        await delay(500);
    }
    if  (isChecked == true)//(document.getElementById(forToggle.id).checked) 
    {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.id = forToggle.id;
        link.href = bookURL + '/css/' + forToggle.id + '.css';
        console.log('Updating CSS to ' + link.href);
        document.head.append(link);
    } 
    else if ((isChecked == false) || (isChecked == null)){
        console.log('Removing ' + forToggle.id);
        var link = document.getElementById(forToggle.id);
        
        if (link) {
            document.head.removeChild(link);
        }
    }
    else if (forToggle == null){
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = bookURL + '/css/default.css';
        document.head.append(link);
    }
    if ((forToggle.id != 'darkmode') && (onPageLoad == false)){
        body.classList.toggle('fade');
    } 
}		


function delay(delayInms) {
return new Promise(resolve => {
setTimeout(() => {
  resolve(2);
}, delayInms);
});
}

function resetStorage(){
    //console.log('Clearing local storage, including display settings.');
    localStorage.clear();
    location.reload();
}

function updateArticleMargin(){
   // console.log("Updating margin with no H2 tags");
    var articleBody = document.getElementsByClassName('article-body');
    //console.log(articleBody);
    articleBody[0].style.marginRight = '0px';

}

function setSidebarActive(){//this sets it up
    var sections = document.querySelectorAll('.page-sidebar-list li a');//get all links to headings
    const scrollPosArray = [0];	
    for( var i = 0; i < sections.length; i++ ){//iterate through headings
        var currentSection = sections[i]; 
        var val = currentSection.getAttribute('href');//get the target for the link
        var refElement = document.querySelector(val);
        scrollPosArray.push(refElement.offsetTop-45);
        //console.log(val + " is at " + refElement.offsetTop);
    }
    if (sections.length > 0) {
        var currentLink = sections[0];
        currentLink.parentElement.classList.remove("active-header");


    window.addEventListener("scroll", () => {
        var currentScrollPos = window.pageYOffset;
        for (var x = scrollPosArray.length; x > 0; x--){
            currentLink.parentElement.classList.remove("active-header");
            if (scrollPosArray[x] < currentScrollPos && currentScrollPos > scrollPosArray[x-1]){
                
                    //console.log("Currently in: " + sections[x-1]); 
                    sections[x-1].parentElement.classList.add("active-header");
                    currentLink = sections[x-1];
                    break;
            }
            else{

            }
        }
        
    });
    }
    
}

function setCurrentPageLink(){
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var navLinks = document.getElementsByTagName("a");
    var i=0;
    var currentPage = url[url.length - 1];
    for(i;i<navLinks.length;i++){
        var lb = navLinks[i].href;//.split("/");
        var theParent = navLinks[i].parentElement.parentElement;
        //console.log(theParent);
        //console.log(lb);
        if (lb == url){

            if (theParent.classList.contains('toc-subsection') || theParent.classList.contains('toc-section')) {
                navLinks[i].classList.add('current-link');
            }
            else{
                console.log('Not gonna highlight this');
            }
            
        }
    }
}


//PROGRESS SLIDER


window.addEventListener('scroll', function(){
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("progress").style.width = scrolled + "%";
});

function setupSmoothScroll(){
    setSidebarActive();
    var button = document.querySelector('.bt-menu-trigger');
    var leftTOC = document.querySelector('.left-toc');
    var articleBody = document.querySelector('.article');
    var headerBar = document.querySelector('.header-bar');
    button.addEventListener('click', function (){
        button.classList.toggle('bt-menu-open');
        leftTOC.classList.toggle('hidden-toc');
        articleBody.classList.toggle('hidden-toc2');
        headerBar.classList.toggle('headerbar-padding');
    });
}

/*
window.matchMedia('(prefers-color-scheme: dark)')
      .addEventListener('change', event => {
        var darkCheckBox = document.getElementById('darkmode');  
        console.log('Checkbox is ' + darkCheckBox.checked);     
        if (event.matches) {
            //dark mode
            console.log('Entering Dark Mode');
            darkCheckBox.checked = true;
   
        } else {
            //light mode
            console.log('Entering Light Mode');
            darkCheckBox.checked = false;
        }
        saveCheckbox(darkCheckBox);
})
*/


