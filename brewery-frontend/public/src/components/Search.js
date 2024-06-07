import React, { useState } from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';

const Search = () => {
    const [searchType, setSearchType] = useState('by_city');
    const [searchTerm, setSearchTerm] = useState('');
    const [breweries, setBreweries] = useState([]);
    const history = useHistory();

    const handleSearch = async () => {
        try {
            const response = await axios.get(`/api/breweries/search?${searchType}=${searchTerm}`);
            setBreweries(response.data);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <div>
            <h2>Search Breweries</h2>
            <div>
                <select value={searchType} onChange={(e) => setSearchType(e.target.value)}>
                    <option value="by_city">City</option>
                    <option value="by_name">Name</option>
                    <option value="by_type">Type</option>
                </select>
                <input type="text" value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                <button onClick={handleSearch}>Search</button>
            </div>
            <div>
                {breweries.map((brewery) => (
                    <div key={brewery.id} onClick={() => history.push(`/brewery/${brewery.id}`)}>
                        <h3>{brewery.name}</h3>
                        <p>{brewery.city}, {brewery.state}</p>
                        <p>{brewery.phone}</p>
                        <a href={brewery.website_url} target="_blank" rel="noopener noreferrer">{brewery.website_url}</a>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default Search;
