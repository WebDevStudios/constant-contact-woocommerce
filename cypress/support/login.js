Cypress.Commands.add('login', (url) => {
	cy.visit( url )
	cy.wait(500)
	cy.get('#user_login')
		.focus()
		.type('admin')
	cy.get('#user_pass')
		.focus()
		.type('admin')
	cy.get('#wp-submit').click()
})
