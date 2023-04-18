let divContainer = document.getElementById('task-dom-con');
let dependencyInput = document.getElementById('myDependency');

dependencyInput.addEventListener('change', () =>{
    let inputsToDelete = document.querySelectorAll(".dom-del");
    inputsToDelete.forEach(e => {
        e.remove();
    });

    let number = dependencyInput.value;
    for(let i = 0; i < number; i++){

        let p = document.createElement("p");
        let label = document.createElement("label");
        let input = document.createElement("input");

        label.innerText = `TaskID #${i + 1}  `;
        input.type = "number";
        input.name = `dependency_${i}`; 
        p.className = "dom-del"; 
        input.className = "dom-button";

        p.appendChild(label);
        label.appendChild(input);
        divContainer.appendChild(p);
    }
})

const submitButton = document.getElementById('submit_button');



// Add an event listener to the form's submit button
// submitButton.addEventListener('submit', function(e) {
//     e.preventDefault();
//     let formData = new FormData(e.target);
//     let inputValues = [];
//     let inputFields = document.querySelectorAll('dom-button');
//     inputFields.forEach(function(input) {
//         inputValues.push(input.value);
//     });
//     formData.append('inputValues', JSON.stringify(inputValues));
//     fetch('insert_task.php', {
//         method: 'POST',
//         body: formData,
//     })
//     .then(response => {}).catch(error => {});
// });

