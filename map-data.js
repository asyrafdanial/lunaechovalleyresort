// Centralized Data Dictionary (Menggantikan Database & PHP)
const resortData = {
    'moraia-suites': {
        name: 'Moraia Suites Wing',
        status: 'Available', // Tukar jadi 'Fully Booked' jika penuh
        operating_hours: '24 Hours Check-in',
        desc: 'The main accommodation wing offering luxurious rooms with panoramic hill views and natural forest scenery.',
        fac: 'King-sized beds, private balconies, smart room controls, premium en-suite bathrooms.',
        act: 'Relaxing, enjoying sunsets, room-service dining.'
    },
    'selene-villas': {
        name: 'Selene Villas',
        status: 'Fully Booked',
        operating_hours: '24 Hours Check-in',
        desc: 'Exclusive, private premium villas nested at the highest point of the resort grounds for maximum seclusion.',
        fac: 'Private plunge pools, dedicated butler service, outdoor rain showers, mini-bars.',
        act: 'Private retreats, honey-moon stays, stargazing.'
    },
    'pavilion-restaurant': {
        name: 'The Pavilion Restaurant',
        status: 'Available',
        operating_hours: '7:00 AM - 11:00 PM',
        desc: 'An open-air dining pavilion offering exquisite organic farm-to-table culinary dishes and refreshments.',
        fac: 'Spacious dining hall, live kitchen counter, buffet island, lounge seating.',
        act: 'Gourmet dining, food tasting, evening beverage social hours.'
    },
    'amora-spa': {
        name: 'Amora Spa & Wellness Center',
        status: 'Available',
        operating_hours: '9:00 AM - 9:00 PM',
        desc: 'A premium relaxation center offering authentic traditional body massages and holistic aromatherapy.',
        fac: 'Therapy rooms, sauna cabins, massage decks, relaxation lounges.',
        act: 'Traditional massages, skin treatments, deep meditation sessions.'
    },
    'luna-hot-springs': {
        name: 'Luna Natural Hot Springs',
        status: 'Available',
        operating_hours: '6:00 AM - 12:00 AM',
        desc: 'Natural geothermal pools rich with healthy minerals, perfect for relaxing your body and sore muscles.',
        fac: 'Thermostatic spring pools, changing lockers, clean shower stations, seating benches.',
        act: 'Mineral soaking, thermal hydrotherapy, evening relaxation.'
    },
    'tennis-courts': {
        name: 'Tennis Courts & Fitness Pavilion',
        status: 'Available',
        operating_hours: '7:00 AM - 10:00 PM',
        desc: 'Outdoor sport layouts and recreation spaces for guests looking to maintain an active lifestyle.',
        fac: 'Standard regulation tennis courts, sports gear rental lockers, night floodlighting.',
        act: 'Tennis matches, morning drills, physical workouts.'
    },
    'orchid-greenhouse': {
        name: 'Orchid Greenhouse',
        status: 'Available',
        operating_hours: '8:00 AM - 6:00 PM',
        desc: 'A climate-controlled glass facility housing a breathtaking collection of rare exotic orchid species.',
        fac: 'Misting irrigation lines, plant information plaques, display walk-paths.',
        act: 'Botanical photography, educational tours, nature walking.'
    },
    'butterfly-sanctuary': {
        name: 'Butterfly Sanctuary',
        status: 'Available',
        operating_hours: '9:00 AM - 5:30 PM',
        desc: 'An enclosed botanical dome filled with thousands of vibrant, free-flying native butterfly species.',
        fac: 'Enclosed netted dome, nectar feeding stations, beautiful floral pathways.',
        act: 'Insect macro photography, educational group tours, lepidoptera observation.'
    },
    'organic-farm': {
        name: 'Organic Farm & Apiary',
        status: 'Available',
        operating_hours: '8:00 AM - 5:00 PM',
        desc: 'An eco-friendly agriculture plot producing fresh organic vegetables and premium natural honey.',
        fac: 'Vegetable vegetable patches, honey-bee apiary boxes, composting bays.',
        act: 'Agricultural harvesting tours, fresh honey sampling, eco-farming workshops.'
    },
    'horse-stable': {
        name: 'Horse Stable & Riding Trail',
        status: 'Available',
        operating_hours: '8:00 AM - 6:00 PM',
        desc: 'Equestrian facilities managing well-trained horses with scenic trail pathways through the resort forest.',
        fac: 'Fenced horse paddocks, riding gear lockers, training rings, natural wilderness trails.',
        act: 'Guided horse riding, stable feeding sessions, equestrian photo shoots.'
    }
};