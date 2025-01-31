import { useUserStore } from '../../stores/user';
import { useRouter } from 'vue-router';
/**
 * Serves as the main file to handle API requests, for custom handling and adding Authorization headers.
 * Easy to migrate between libraries(for example axios)
 * 
 */

/**
 * Makes a GET request to the specified URL and returns the response as JSON.
 *
 * @param {string} url - URL to send the GET request to.
 * @returns {Promise<Object>} returns response data as a JSON object.
 * @catch Will log an error to the console if the request fails. can be expanded to handle errors.
 * 
 */
export const get = async (url) => {
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
        },
    })

    return handleResponse(response);
};

/**
 * Sends a POST request to the specified URL with the given data.
 *
 * @param {string} url - URL to send the POST request to.
 * @param {Object} data - The data to be sent in the body of the POST request.
 * @returns {Promise<Object>} returns response data as a JSON object.
 * @catch Will log an error to the console if the request fails. can be expanded to handle errors.
 * 
 */
export const post = async (url, data) => {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
        },
        body: JSON.stringify(data),
        credentials: 'include'
    })

    return handleResponse(response);
};

/**
 * Sends a PUT request to the specified URL with the given data.
 *
 * @param {string} url - URL to send the PUT request to.
 * @param {Object} data - The data to be sent in the body of the POST request.
 * @returns {Promise<Object>} returns response data as a JSON object.
 * @catch Will log an error to the console if the request fails. can be expanded to handle errors.
 * 
 */
export const put = async (url, data) => {
    const response = await fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
        },
        body: JSON.stringify(data),
    })

    return handleResponse(response);
};

/**
 * Sends a DELETE request to the specified URL.
 *
 * @param {string} url - URL to send the DELETE request to.
 * @returns {Promise<Object>} returns response data as a JSON object.
 * @catch Will log an error to the console if the request fails. can be expanded to handle errors.
 * 
 */
export const deleteRequest = async (url) => {
    const response = await fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
        },
    })

    return handleResponse(response);
}

const handleResponse = async (response) => {
    //logout the user if error is 401
    if (response.status === 401) {
        const store = useUserStore();
        store.logout();
        const router = useRouter();
        router.push('/login');
    }

    if (!response.ok) {
        return response.json().then((data) => {
            throw new Error(data.message);
        });
    }

    return response.json();
}