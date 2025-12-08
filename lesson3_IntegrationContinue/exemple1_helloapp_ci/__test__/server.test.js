const request = require('supertest');
const app = require('../src/server'); // Importe l'application Express exportée

describe('GET /', () => {
  it('devrait répondre avec un statut 200 et contenir le titre', async () => {
    // On vérifie l'accessibilité de la page
    const response = await request(app).get('/');
    expect(response.statusCode).toBe(200);
    // On vérifie que le corps de la réponse contient le titre de la page
    expect(response.text).toContain('<h1>Welcome to my awesome app!</h1>');
  });
});
