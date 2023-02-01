
describe('guest.cy.js', () => {
    beforeEach(() => {
        cy.visit('/');
    })

    it('visits home page', () => {
        cy.contains('Home page');
    })

    it('visits login page', () => {
        cy.get('[href="/login"]').click();
        cy.contains('Login page');
    })

    it('visits registration page', () => {
        cy.get('[href="/registration"]').click();
        cy.contains('Registration page');
    })
});