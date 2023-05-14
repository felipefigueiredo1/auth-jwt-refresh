const form = document.querySelector("#form");
const btn_check_auth = document.querySelector("#btn_check_auth");
const authDiv = document.querySelector("#auth-div")
const logoffButton = document.querySelector("#logoff");
const resource = document.querySelector("#resource");

axios.defaults.baseURL = 'http://0.0.0.0:80'

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    authenticateUser(formData)
});

btn_check_auth.addEventListener('click', async(e) => {
    verifyUserToken()
});

logoffButton.addEventListener('click', () => {
    logoff()
});

resource.addEventListener('click', () => {
    bringsResource();
});

async function authenticateUser(formData) {
    try {
        const { data } = await axios.post('login', formData);
        sessionStorage.setItem('jwt', data.jwt);
        sessionStorage.setItem('rjwt', data.rjwt);
        authDiv.style.display = 'block';
        logoffButton.style.display = 'block';
    } catch(error) {
        console.log(error);
    }
}

async function verifyUserToken() {
    try {
        if(sessionStorage.getItem('jwt') && sessionStorage.getItem('rjwt')) {
            const authSession = 'Bearer ' + sessionStorage.getItem('jwt');
        
            const { data } = await axios.get('auth', {
                headers: { 
                    "Authorization": authSession
                }
            });
            
            if(data.message == 'Expired token') {
                await refreshToken(sessionStorage.getItem('rjwt'));
            } else {
                alert('Autenticado')
            }

            authDiv.style.display = 'block';
            logoffButton.style.display = 'block';

            return true;
        } else {
            alert('Não está autenticado')
            authDiv.style.display = 'none';
            logoffButton.style.display = 'none';
            return false;
        }
    } catch(error) {
        console.log(error)

        return false;
    }
}

async function refreshToken(refreshToken) {
    try {
        const authSession = 'Bearer ' + refreshToken;

        const { data } = await axios.get('refresh', {
            headers: { 
                "Authorization": authSession
            }
        });

        if(data.jwt) {
            sessionStorage.setItem('jwt', data.jwt);
            alert('Autenticado, refresh token');
        } 
    }catch(error) {
        alert(error);
    }
}

function logoff() {
    sessionStorage.removeItem('jwt');
    sessionStorage.removeItem('rjwt');

    authDiv.style.display = 'none';
    logoffButton.style.display = 'none';
}

async function bringsResource() {
    if(await verifyUserToken()) {
        const authSession = 'Bearer ' + sessionStorage.getItem('jwt');
        const { data } = await axios.get('resource', {
            headers: { 
                "Authorization": authSession
            }
        });

        authDiv.innerHTML = authDiv.innerHTML + ' ' + data.text;
    } else {
        alert('Faça login')
    }
}