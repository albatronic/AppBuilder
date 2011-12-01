function cambiarpesta(){
    elList = document.getElementsByTagName("a");

    for (i = 0; i < elList.length; i++){

        if ((elList[i].className=="tab")||(elList[i].className=="tab activeTab"))
        {
            elList[i].className='tab';
        }
    }

}