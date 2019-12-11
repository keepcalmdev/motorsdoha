/*----------------- SEO ----------------- */
//H1 TITLE 
function chngTtl(titleObj){
    var lang = jQuery('html').attr("lang")
    var top_title = ""
    if(titleObj["condition"] == "new-cars"){//NEW CARS

        if(lang != "en-US") top_title = "سيارات "+titleObj["make"]+" "+titleObj["model"]+" جديدة في قطر"                   
            else top_title = "New "+titleObj["make"]+" "+titleObj["model"]+" Cars in Qatar"       

    } else if(titleObj["condition"] == "used-cars") {//USED CARS

        if(lang != "en-US") top_title = "سيارات "+titleObj["make"]+" "+titleObj["model"]+" مستعملة في قطر"  
            else top_title = "Used "+titleObj["make"]+" "+titleObj["model"]+" Cars in Qatar"

    } else {
        if(titleObj["make"] !=="" || titleObj["model"] !== ""){//WITHOUT CONDITION
            if(lang != "en-US"){

                if(titleObj["model"] === "") top_title = titleObj["make"]+" سيارات للبيع في قطر"                        
                    else top_title = titleObj["make"]+" "+ titleObj["model"] +" في قطر"    

                
            } else {

                if(titleObj["model"] === "") top_title = titleObj["make"]+" Cars for Sale in Qatar"                       
                    else top_title = titleObj["make"]+" "+titleObj["model"]+" in Qatar"                       
                
            }
        } else {

            if(lang != "en-US") top_title = "قائمة السيارات"
                 else top_title = "Inventory"

        }
    }
    top_title = top_title.replace("  ", " ")
    $("h1.title").html(top_title)              
}

//<TITLE>
function changeSeo(){
    var lang = jQuery('html').attr("lang")
    var title = "";
    var desc = "";
    var makelVal = $("select[name=make] option:selected").html();
    var make=($("select[name=make]").val() === "")? "": capitalizeFL(makelVal);
    var modelVal = $("select[name=serie] option:selected").html()
    var model = ($("select[name=serie]").val() === "")? "": modelVal
    var year=$("select[name=ca-year]").val();
    var condition = $("select[name=condition]").val()
    var titleObj = {"make": make, "model": model, "year": year, "condition": condition }
    if(titleObj["condition"] == "new-cars"){//NEW CARS
        if( titleObj["make"] === "" && titleObj["model"] === "" ) {//NEW CARS DEFAULT

            if(lang != "en-US") title = "سيارات جديدة في قطر، مقالات وأسعار، اشترِ سيارة جديدة | مواتر الدوحة"
                else title ="New Cars in Qatar, Reviews and Prices, Buy New Car | MotorsDoha "
    
        } else {
            if(titleObj["model"] === ""){//NEW MAKE CARS

                if(lang != "en-US") title = "سيارات "+titleObj["make"]+" جديدة للبيع في قطر | مواتر الدوحة"
                    else title = "New "+titleObj["make"]+" Cars for Sale in Qatar | MotorsDoha"

                
            } else {//NEW MODEL CARS

                if(lang != "en-US") title = "الأسعار، سيارات "+titleObj["year"]+" "+titleObj["make"]+" "+titleObj["model"]+" للبيع في قطر | مواتر الدوحة"
                    else title = titleObj["year"]+ " " +titleObj["make"]+" "+titleObj["model"]+ "Prices, Cars for Sale in Qatar | MotorsDoha"

            }
        }
    } else if(titleObj["condition"] == "used-cars") {//USED CARS
        if( titleObj["make"] === "" && titleObj["model"] === "" ) {//USED CARS DEFAULT
            if(lang != "en-US") title = "سيارات مستعمله للبيع في قطر، اشترِ سيارة مستعملة | مواتر الدوحة"
                else title = "Used Cars for Sale in Qatar, Buy Second Hand Car | MotorsDoha"
            
        } else {
            if(titleObj["model"] === ""){//USED MAKE CARS

                if(lang != "en-US") title = "سيارات "+titleObj["make"]+" مستعملة للبيع في قطر | مواتر الدوحة"
                    else title = titleObj["make"]+ " Used Cars for Sale in Qatar | MotorsDoha"
                
            } else { //USED MODEL CARS

                if(lang != "en-US") title = "سيارات "+titleObj["make"]+" "+titleObj["model"]+" مستعملة للبيع في قطر | مواتر الدوحة"
                    else title = "Used "+titleObj["make"]+" "+titleObj["model"]+" Cars for Sale in Qatar | MotorsDoha"

            }
        }
    } else {//CONDITION
        if(titleObj["make"] !== "" || titleObj["model"] !=="" ){

            if(lang != "en-US"){
                if(titleObj["make"] !== "" && titleObj["model"] ===""){ //WITHOUT CONDITION MAKE
                    title = titleObj["make"]+" سيارات للبيع، السعر في قطر | مواتر الدوحة"
                } else if(titleObj["make"] != "" && titleObj["model"] !="") { //WITHOUT CONDITION MODEL
                    title ="سيارات "+titleObj["make"]+" "+titleObj["model"]+" للبيع، السعر في قطر | مواتر الدوحة"
                } 
            } else {//WITHOUT CONDITION MAKE/MODEL EN
                title = titleObj["make"]+ " " +titleObj["model"]+ " Cars for Sale, Price in Qatar | MotorsDoha"
                title = title.replace('  ', " ")
            }

        } else {//CONDITION DEFAULT

            if(lang != "en-US") title = "بيع السيارات في قطر، اشترِ سيارات جديدة ومستعملة | مواتر الدوحة"
                else title = "Qatar car Sale, Buy New & Used Vehicles | MotorsDoha"

        } 
    }
    if( $("meta[name=description]").length > 0) $("meta[name=description]").remove()
    $("title").html(title)         
    chngTtl(titleObj)  
}

function capitalizeFL(name){ return name.charAt(0).toUpperCase() + name.slice(1) }