function showConfirmDialog(module, removeId, country) {
    var r = confirm("Are you sure you want to delete it?");
    if (r === true) {
        window.location.replace("index.php?module=" + module + "&action=delete&id=" + removeId + "&country=" + country);
    }
}

function lookFor(){
    console.log("fired up");
    var search = document.getElementById('search').value;

    if (isNaN(search))
    {
        console.log(search);
        if (window.location.href.indexOf("cityController") > -1)
        {
            var country = getCountry();
            console.log(country);
            console.log('index.php?module=cityController&action=list&country=' + country + '&page=' + page + '&search=' + search + '&sort=' + sort);
            $('#contentMain').load('index.php?module=cityController&action=list&country=' + country + '&page=' + page + '&search=' + search + '&sort=' + sort);
        
        } else 
        {
            $('#contentMain').load('index.php?module=countryController&action=list&page=' + page + '&search=' + search + '&sort=' + sort);
        }
    } else if (!search) {
        alert("Are you searching for nothing?");
    } else {
        alert("Name does not cointain only numbers!");
    }
}

function date_filter(){
    console.log("filter function for date");

    if (document.getElementById("date_from").value || document.getElementById("date_to").value)
    {
        var sql_date_from = '';

        if(document.getElementById("date_from").value){
            var date_from = new Date(document.getElementById("date_from").value);
            sql_date_from = Date_toYMD(date_from);
        }

        if(document.getElementById("date_to").value)
        {
            var date_to= new Date(document.getElementById("date_to").value);
            sql_date_to = Date_toYMD(date_to);
        } else {
            var date_to = new Date();
            sql_date_to = Date_toYMD(date_to);
        }
        
        console.log(date_from);
        console.log(date_to);

        var search = document.getElementById('search').value;
    
        if(sql_date_from > sql_date_to)
        {
            alert("Starting date should be older or equal to ending date!");
        } else {
            if (window.location.href.indexOf("cityController") > -1)
            {
                var country = getCountry();
                console.log(country);
                $('#contentMain').load('index.php?module=cityController&action=list&country=' + country + '&page=' + page + '&search=' + search + '&sort=' + sort + '&from=' + sql_date_from + '&to=' + sql_date_to);
            
            } else {
                $('#contentMain').load('index.php?module=countryController&action=list&page=' + page + '&search=' + search + '&sort=' + sort + '&from=' + sql_date_from + '&to=' + sql_date_to);
            }
        }   
    } else {
        alert("Choose date from and/or date to for filtering!");
    }
}

function Date_toYMD(date) {
    var year, month, day;
    year = String(date.getFullYear());
    month = String(date.getMonth() + 1);
    if (month.length == 1) {
        month = "0" + month;
    }
    day = String(date.getDate());
    if (day.length == 1) {
        day = "0" + day;
    }
    return year + "-" + month + "-" + day;
}

function getCountry() {
    var urlParams = getUrlParams();
    var country = urlParams.get('country')

    return country;
}

function getUrlParams() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    return urlParams;
}


