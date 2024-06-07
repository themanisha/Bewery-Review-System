const express = require('express');
const router = express.Router();
const axios = require('axios');
const Review = require('../models/Review');
const jwt = require('jsonwebtoken');

const authenticateToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];
    if (token == null) return res.sendStatus(401);

    jwt.verify(token, process.env.JWT_SECRET, (err, user) => {
        if (err) return res.sendStatus(403);
        req.user = user;
        next();
    });
};

router.get('/search', async (req, res) => {
    const { by_city, by_name, by_type } = req.query;
    let url = 'https://api.openbrewerydb.org/breweries';
    if (by_city) url += `?by_city=${by_city}`;
    if (by_name) url += `?by_name=${by_name}`;
    if (by_type) url += `?by_type=${by_type}`;

    try {
        const response = await axios.get(url);
        res.json(response.data);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

router.get('/:id', async (req, res) => {
    const { id } = req.params;
    try {
        const response = await axios.get(`https://api.openbrewerydb.org/breweries/${id}`);
        const reviews = await Review.find({ breweryId: id }).populate('userId', 'name');
        res.json({ ...response.data, reviews });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

router.post('/:id/review', authenticateToken, async (req, res) => {
    const { id } = req.params;
    const { rating, description } = req.body;
    try {
        const newReview = new Review({ userId: req.user.id, breweryId: id, rating, description });
        await newReview.save();
        res.status(201).json({ message: 'Review added' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
