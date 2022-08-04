(()=>{
    let screen_area = document.querySelector('body');
    let screen_ctrl = document.querySelector('#screen_ctrl');
    let page_ctrl = document.querySelector('.page_ctrl');
    let wrapper = document.querySelector('#wrapper');
    let page_content_wrapper = document.querySelector('#page-content-wrapper');
    if(wrapper){
        wrapper.classList.add('toggled');
    }
    
    if(screen_ctrl && screen_area){
        screen_ctrl.addEventListener('click', ()=>{
            if(navigator.vendor != "Google Inc."){
                fullScreen();
            }else{
                if(check() == 'fullscreen'){
                    exitFullscreen();
                }else{
                    fullScreen();
                }
            }
            
        });
    }
    
    function fullScreen() {
        if (screen_area.requestFullscreen) {
            screen_area.requestFullscreen();
        } else if (screen_area.webkitRequestFullscreen) {
            screen_area.webkitRequestFullscreen();
        } else if (screen_area.msRequestFullscreen) {
            screen_area.msRequestFullscreen();
        }
    }
    
    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
    
    // window.addEventListener('load', ()=>{
    //     fullScreen();
    // });
    
    function check() {
        if (!window.screenTop && !window.screenY) {
            return 'notfullscreen';
        } else {
             return 'fullscreen';
        }
    }
    
    document.addEventListener('fullscreenchange', ()=>{
        if(check() == 'fullscreen' && page_ctrl){
            page_ctrl.classList.add('active');
        }else if(page_ctrl){
             page_ctrl.classList.remove('active');
        }
    });
    
    // Clock Management
    
    var interval_id = setInterval(function(){
        let h = document.querySelector('#h');
        let i = document.querySelector('#i');
        let s = document.querySelector('#s');
        let a = document.querySelector('#a');

		if(h && i && s && a){
	        // work with s start---------------------------
	        // check s > 0
	        if(s.innerHTML>=0 && s.innerHTML<59){
	            let temp_sec = (+s.innerHTML+1);
	            s.innerHTML = (temp_sec>9) ? temp_sec : "0"+temp_sec;
	        }else{
	            s.innerHTML = "00";

	            // work with i start---------------------------
	            // check i > 0
	            if(i.innerHTML>=0 && i.innerHTML<59){
	                let temp_i  = (+i.innerHTML+1);
	                i.innerHTML = (temp_i>9) ? temp_i : "0"+temp_i;
	            }else{
	                i.innerHTML = "00";
	            
	                // work with i start---------------------------
	                if(h.innerHTML>0 && h.innerHTML<12){
	                    let temp_h = (+h.innerHTML+1);
	                    h.innerHTML = (temp_h>9) ? temp_h : "0"+temp_h;;
	                }else{
	                    h.innerHTML = "01";
	                    if(a){
	                        a.innerHTML = (a.innerHTML=='am') ? "pm" : "am";
	                    }
	                }
	            }
	        }
        }
    }, 1000);

    
})()