import { registerBlockType } from '@wordpress/blocks';

// Vacancies
import * as vacancies from './vacancies';

const blocks = [
	vacancies
]

blocks.forEach( ( block ) => {
	const { name, settings } = block;

	return registerBlockType( name, settings );
} );