window.onload = function() {
   
}
window.onload =function() {
    
}
window.onload = function() {
   loadCheckboxes();
   setCurrentPageLink();
   setupSmoothScroll();
}

function loadCheckboxes(){
    var list = document.querySelectorAll(`[type*="checkbox"]`);
    //console.log("There are " + list.length + ' checkboxes to check');
    console.log(localStorage);
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
        }
       
    });
} 


function saveCheckbox(thisCheckbox){
    //console.log('ID is: ' + thisCheckbox.id);  
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

async function updateCSS(forToggle, isChecked,onPageLoad)
{
    var bookURL = bookSSURL.templateUrl;
    //console.log("Updating CSS for Toggle:" + forToggle.id);
    var body = document.body
    if ((forToggle.id != 'darkmode') && (onPageLoad == false)){
        body.classList.toggle('fade');
        await delay(500);
    }
    if  (isChecked == true)//(document.getElementById(forToggle.id).checked) 
    {
       // console.log('Theme URL is ' + bookURL);
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
        scrollPosArray.push(refElement.offsetTop-50);
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
    //console.log(url);
    //var url = "http://example.com/products.html".split("/"); //replace string with location.href
    var navLinks = document.getElementsByTagName("a");
    //console.log('There are ' + navLinks.length + ' Nav links');
    //naturally you could use something other than the <nav> element
    //console.log("There are " + navLinks.length + ' links to check');
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
function updateProgress(num1, num2){
    var percent = ( num1 / num2 * 100) 
    var percentRounded = percent.toFixed(1) + '%';
    //console.log("Scrolling to " + percentRounded);
    document.getElementById('progress').style.width = percentRounded;
    }

window.addEventListener('scroll', function(){
    var top = window.scrollY;
    var height = document.body.getBoundingClientRect().height - window.innerHeight;
    updateProgress(top, height);
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


