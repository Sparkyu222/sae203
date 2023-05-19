const 

    // Onglet variables
        ongletBtn = document.querySelectorAll('.onglet-btn'),
        ongletLayout = document.querySelectorAll('.onglet-layout');

let 
    // Onglet variables
        index = 0;



// Onglet switch system
function ongletSet() {
    ongletBtn.forEach(function(onglet){
        onglet.addEventListener('click', () => {
            ongletSelector(onglet.getAttribute('data-onglet'));
        })
    })
}

function ongletSelector(index) {
    console.log('on tente de changer donglet');
    ongletBtn.forEach(function(onglet) {
        // if(onglet.classList.contains('a-onglet')){
        //     return;
        // } else {
        //     onglet.classList.add('a-onglet');
        // }

        // for(i = 0; i < ongletBtn.length; i++) {
        //     if(ongletBtn[i].getAttribute('data-onglet') !== index){
        //         ongletBtn[i].classList.remove('a-onglet');
        //     }
        // }

        for(j = 0; j < ongletLayout.length; j++) {
            if(ongletLayout[j].getAttribute('data-onglet') == index) {
                ongletLayout[j].classList.remove('hidden');
            } else {
                ongletLayout[j].classList.add('hidden');
            }
        }
    });
}