import React, { useState } from 'react';
import axios from 'axios';

const ReviewForm = ({ breweryId, addReview }) => {
    const [rating, setRating] = useState(1);
    const [description, setDescription] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const token = localStorage.getItem('token');
            const response = await axios.post(
                `/api/breweries/${breweryId}/review`,
                { rating, description },
                { headers: { 'Authorization': `Bearer ${token}` } }
            );
            addReview(response.data);
            setRating(1);
            setDescription('');
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label>Rating:</label>
                <input type="number" value={rating} onChange={(e) => setRating(e.target.value)} min="1" max="5" required />
            </div>
            <div>
                <label>Description:</label>
                <textarea value={description} onChange={(e) => setDescription(e.target.value)} required />
            </div>
            <button type="submit">Add Review</button>
        </form>
    );
};

export default ReviewForm;
