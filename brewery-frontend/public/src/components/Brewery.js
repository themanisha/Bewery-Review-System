import React, { useState, useEffect } from 'react';
import axios from 'axios';
import ReviewForm from './ReviewForm';

const Brewery = ({ match }) => {
    const [brewery, setBrewery] = useState(null);
    const [reviews, setReviews] = useState([]);

    useEffect(() => {
        const fetchBrewery = async () => {
            try {
                const response = await axios.get(`/api/breweries/${match.params.id}`);
                setBrewery(response.data);
                setReviews(response.data.reviews);
            } catch (error) {
                console.error(error);
            }
        };

        fetchBrewery();
    }, [match.params.id]);

    const addReview = (review) => {
        setReviews([...reviews, review]);
    };

    return (
        <div>
            {brewery ? (
                <>
                    <h2>{brewery.name}</h2>
                    <p>{brewery.street}, {brewery.city}, {brewery.state}</p>
                    <p>{brewery.phone}</p>
                    <a href={brewery.website_url} target="_blank" rel="noopener noreferrer">{brewery.website_url}</a>
                    <h3>Reviews</h3>
                    {reviews.map((review) => (
                        <div key={review._id}>
                            <p><strong>{review.userId.name}</strong> rated it {review.rating}/5</p>
                            <p>{review.description}</p>
                        </div>
                    ))}
                    <ReviewForm breweryId={brewery.id} addReview={addReview} />
                </>
            ) : (
                <p>Loading...</p>
            )}
        </div>
    );
};

export default Brewery;
