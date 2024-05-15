const decresebtn = document.getElementById("decbtn");
        const incresebtn = document.getElementById("incbtn");
        const display = document.getElementById("quantity");
        let pop = document.getElementById("popup");
        let menutoggle = document.getElementById("submenu");

        let counter=0;

        decresebtn.onclick = function(){
            if(counter>0){
                counter--;
            }
            display.innerHTML = counter;
        }
        incresebtn.onclick = function(){
                counter++;
            display.innerHTML = counter;
        }

        // function openpopup(){
        //     pop.classList.add("open-pop");
        // }

        function openpopup(image, name, price) {

            document.getElementById("popup_image").src = image;
            document.getElementById("popup_name").innerText = name;
            document.getElementById("popup_price").innerText = "Price: " + price;

            pop.classList.add("open-pop");
        }

        function closepopup(){
            pop.classList.remove("open-pop");
        }
        
        function togglemenu(){
            menutoggle.classList.toggle("open-menu");
        }


        