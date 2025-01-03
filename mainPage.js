document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.getElementById('addButton');
    const popUp = document.getElementById('popUp');
    const closeButton = document.querySelector('.closeButton');
    const popUpForm = document.getElementById('popUpForm');
    const mainContainer = document.querySelector('.scrollContainer');
    let currentContainer = null;

    function strongPass() {
        const chars = ["abcdefghijklmnopqrstuvwxyz", "ABCDEFGHIJKLMNOPQRSTYVWXYZ", "0123456789", "(_-<>!@#$%^&)+="];
        const length = Math.floor(Math.random() * 5) + 8;
        let strongPassword = "";

        for (let i = 0; i < length; i++) {
            let arrInd = Math.floor(Math.random() * 4);
            let charInd = Math.floor(Math.random() * chars[arrInd].length);
            strongPassword += chars[arrInd].charAt(charInd);
        }

        return strongPassword;
    }

    function populateServices(services) {
        services.forEach((service) => {
            const {service_name, email, username, strong_password} = service;

            const newContainer = document.createElement('div');
            newContainer.className = 'container';

            newContainer.setAttribute('data-strong-password', strong_password);

            newContainer.innerHTML = `
                <h4 class="containerTitle">${service_name}</h4>
                <div class="containerItem">
                    <label class="containerHeader">Email:</label>
                    <label class="containerSublabels">${email}</label>
                </div>
                <div class="containerItem">
                    <label class="containerHeader">Username:</label>
                    <label class="containerSublabels">${username}</label>
                </div>
                <div class="containerItem">
                    <label class="containerHeader">Safe Password:</label>
                    <label class="containerSublabels">${strong_password}</label>
                </div>
                <div class="buttonHolder">
                    <input class="containerButtons editButton" type="image" src="images/pen.png" alt="Edit">
                    <input class="containerButtons deleteButton" type="image" src="images/delete.png" alt="Delete">
                </div>
            `;

            mainContainer.appendChild(newContainer);

            attachEventListeners(newContainer);
        });
    }

    function attachEventListeners(container) {
        const deleteButton = container.querySelector('.deleteButton');
        const editButton = container.querySelector('.editButton');

        deleteButton.addEventListener('click', () => {
            if (confirm("Are you sure you want to delete this service?")) {
                container.remove();
            }
        });

        editButton.addEventListener('click', () => {
            currentContainer = container;
            popUp.style.display = 'flex';
            popUp.style.justifyContent = 'center';
            popUp.style.alignItems = 'center';

            document.getElementById('service').value = container.querySelector('.containerTitle').textContent;
            document.getElementById('email').value = container.querySelector('.containerItem:nth-child(2) .containerSublabels').textContent;
            document.getElementById('username').value = container.querySelector('.containerItem:nth-child(3) .containerSublabels').textContent;
        });
    }

    populateServices(userServices);

    addButton.addEventListener('click', () => {
        currentContainer = null;
        popUp.style.display = 'flex';
        popUp.style.justifyContent = 'center';
        popUp.style.alignItems = 'center';
        popUpForm.reset();
    });

    closeButton.addEventListener('click', () => {
        popUp.style.display = 'none';
    });

    popUpForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const serviceName = document.getElementById('service').value;
        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        let strongPassword;

        if (currentContainer) {
            strongPassword = currentContainer.getAttribute('data-strong-password');
            currentContainer.querySelector('.containerTitle').textContent = serviceName;
            currentContainer.querySelector('.containerItem:nth-child(2) .containerSublabels').textContent = email;
            currentContainer.querySelector('.containerItem:nth-child(3) .containerSublabels').textContent = username;
            currentContainer.querySelector('.containerItem:nth-child(4) .containerSublabels').textContent = strongPassword;
        } else {
            strongPassword = strongPass();
            const newContainer = document.createElement('div');
            newContainer.className = 'container';

            newContainer.setAttribute('data-strong-password', strongPassword);

            newContainer.innerHTML = `
                <h4 class="containerTitle">${serviceName}</h4>
                <div class="containerItem">
                    <label class="containerHeader">Email:</label>
                    <label class="containerSublabels">${email}</label>
                </div>
                <div class="containerItem">
                    <label class="containerHeader">Username:</label>
                    <label class="containerSublabels">${username}</label>
                </div>
                <div class="containerItem">
                    <label class="containerHeader">Safe Password:</label>
                    <label class="containerSublabels">${strongPassword}</label>
                </div>
                <div class="buttonHolder">
                    <input class="containerButtons editButton" type="image" src="images/pen.png" alt="Edit">
                    <input class="containerButtons deleteButton" type="image" src="images/delete.png" alt="Delete">
                </div>
            `;

            mainContainer.appendChild(newContainer);
            attachEventListeners(newContainer);
        }

        const formData = new FormData(popUpForm);
        formData.append('strong_password', strongPassword);

        fetch('addService.php', {
            method: 'POST',
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                console.log('Service added successfully:', data);
            } else {
                console.error('Error adding service:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });

        popUp.style.display = 'none';
    });

    document.querySelectorAll('.container').forEach(attachEventListeners);
});
