import { post } from '../ApiWrapper';

/**
 * Sends a POST request to the login endpoint with the given credentials.
 * 
 * @param {Object} credentials - The user's login credentials.
 * 
 */
export const postLogin = (credentials) => {
    try {
        return post('/api/login', credentials);
    } catch (error) {
        console.log(error);
    }
};